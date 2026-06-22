<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    public function index(Request $request)
    {
        $technologies = Technology::with(['organization', 'owner'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->get('q');
                $query->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('problem', 'like', "%{$q}%")
                        ->orWhere('solution', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->get('category')))
            ->when($request->filled('trl'), fn ($query) => $query->where('trl', $request->integer('trl')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->get('status')))
            ->latest()
            ->paginate($request->integer('per_page', 12));

        return response()->json($technologies);
    }

    public function show(Technology $technology)
    {
        $technology->load(['organization', 'owner', 'patents']);
        return response()->json($technology);
    }
}
