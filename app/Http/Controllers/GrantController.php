<?php

namespace App\Http\Controllers;

use App\Models\Grant;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index(Request $request)
    {
        $grants = Grant::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->q}%")
                        ->orWhere('description', 'like', "%{$request->q}%")
                        ->orWhere('provider', 'like', "%{$request->q}%");
                });
            })
            ->orderByRaw('deadline IS NULL, deadline ASC')
            ->paginate(12)
            ->withQueryString();

        return view('grants.index', compact('grants'));
    }
}
