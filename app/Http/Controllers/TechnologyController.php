<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzePatentRequest;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Organization;
use App\Models\Technology;
use App\Models\TrlQuestion;
use App\Services\AIAssistantService;
use App\Services\TRLService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnologyController extends Controller
{
    public function index(Request $request)
    {
        $technologies = Technology::with(['organization', 'owner'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->q}%")
                        ->orWhere('description', 'like', "%{$request->q}%");
                });
            })
            ->when($request->filled('trl'), fn ($query) => $query->where('trl', $request->integer('trl')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('technologies.index', compact('technologies'));
    }

    public function create()
    {
        $trlQuestions = TrlQuestion::orderBy('level')->orderBy('order')->get();
        $organizations = Organization::whereIn('type', ['university', 'nii', 'lab', 'tech-park', 'University', 'NII', 'Lab', 'Tech-park'])
            ->orderBy('name')
            ->get();

        return view('technologies.create', compact('trlQuestions', 'organizations'));
    }

    public function store(StoreTechnologyRequest $request, TRLService $trlService)
    {
        $validated = $request->validated();
        $validated['trl'] = $trlService->calculateLevel(
            $validated['trl_answers'] ?? [$validated['trl'] ?? 1]
        );
        unset($validated['trl_answers']);

        Technology::create([
            ...$validated,
            'owner_id' => Auth::id(),
        ]);

        return redirect()
            ->route('technologies.index')
            ->with('success', 'Разработка успешно добавлена.');
    }

    public function show(Technology $technology)
    {
        $technology->load(['organization', 'owner', 'patents', 'investments.investor']);

        return view('technologies.show', compact('technology'));
    }

    public function edit(Technology $technology)
    {
        abort_unless($technology->owner_id === Auth::id() || Auth::user()?->role === 'agency', 403);

        $trlQuestions = TrlQuestion::orderBy('level')->orderBy('order')->get();
        $organizations = Organization::whereIn('type', ['university', 'nii', 'lab', 'tech-park', 'University', 'NII', 'Lab', 'Tech-park'])
            ->orderBy('name')
            ->get();

        return view('technologies.create', compact('technology', 'trlQuestions', 'organizations'));
    }

    public function update(UpdateTechnologyRequest $request, Technology $technology, TRLService $trlService)
    {
        $validated = $request->validated();
        $validated['trl'] = $trlService->calculateLevel(
            $validated['trl_answers'] ?? [$validated['trl'] ?? $technology->trl]
        );
        unset($validated['trl_answers']);

        $technology->update($validated);

        return redirect()
            ->route('technologies.show', $technology)
            ->with('success', 'Разработка успешно обновлена.');
    }

    public function destroy(Technology $technology)
    {
        abort_unless($technology->owner_id === Auth::id() || Auth::user()?->role === 'agency', 403);

        $technology->delete();

        return redirect()
            ->route('technologies.index')
            ->with('success', 'Разработка удалена.');
    }

    public function aiAnalyze(AnalyzePatentRequest $request, AIAssistantService $service)
    {
        return response()->json($service->analyzePatent($request->validated('text')));
    }
}
