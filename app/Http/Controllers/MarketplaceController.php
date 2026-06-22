<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $technologies = Technology::with(['organization', 'owner'])
            ->whereIn('status', ['selling', 'licensing', 'investor_searching', 'ready', 'available'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->q}%")
                        ->orWhere('description', 'like', "%{$request->q}%");
                });
            })
            ->when($request->filled('trl_min'), fn ($query) => $query->where('trl', '>=', $request->integer('trl_min')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('marketplace.index', compact('technologies'));
    }
}
