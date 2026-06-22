<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grant;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index(Request $request)
    {
        $grants = Grant::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->get('q');
                $query->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate($request->integer('per_page', 12));

        return response()->json($grants);
    }

    public function show(Grant $grant)
    {
        return response()->json($grant);
    }
}
