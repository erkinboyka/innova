<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreExchangeRequestRequest;
use App\Models\ExchangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = ExchangeRequest::with('company')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->q}%")
                        ->orWhere('description', 'like', "%{$request->q}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('requests.index', compact('requests'));
    }

    public function store(StoreExchangeRequestRequest $request)
    {
        ExchangeRequest::create([
            ...$request->validated(),
            'company_id' => Auth::id(),
            'status' => 'open',
        ]);

        return redirect()
            ->route('requests.index')
            ->with('success', 'Технологический запрос опубликован.');
    }
}
