<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\User;
use App\Models\Grant;
use App\Models\Organization;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $q = $request->get('q');
        
        if (empty($q)) {
            return response()->json([
                'results' => [
                    'technologies' => [],
                    'scientists' => [],
                    'organizations' => [],
                    'grants' => [],
                ]
            ]);
        }

        $technologies = Technology::query()
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get(['id', 'title', 'description', 'trl']);

        $scientists = User::query()
            ->where('role', 'SCIENTIST')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('bio', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'role', 'avatar']);

        $organizations = Organization::query()
            ->where('name', 'like', "%{$q}%")
            ->limit(5)
            ->get(['id', 'name', 'type', 'logo']);

        $grants = Grant::query()
            ->where('title', 'like', "%{$q}%")
            ->limit(5)
            ->get(['id', 'title', 'budget', 'deadline']);

        return response()->json([
            'results' => [
                'technologies' => $technologies,
                'scientists' => $scientists,
                'organizations' => $organizations,
                'grants' => $grants,
            ]
        ]);
    }
}
