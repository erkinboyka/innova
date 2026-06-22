<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRequest;
use App\Models\Grant;
use App\Models\Investment;
use App\Models\Technology;
use App\Models\User;

class StatsController extends Controller
{
    public function home()
    {
        return response()->json([
            'stats' => [
                'projects' => Technology::count(),
                'scientists' => User::where('role', 'SCIENTIST')->count(),
                'investors' => User::where('role', 'INVESTOR')->count(),
                'total_investments' => Investment::whereIn('status', ['approved', 'completed'])->sum('amount'),
            ],
            'featured_technologies' => Technology::with(['owner', 'organization'])->latest()->take(6)->get(),
            'upcoming_grants' => Grant::query()->orderByRaw('deadline IS NULL, deadline ASC')->take(3)->get(),
            'active_requests' => ExchangeRequest::with('company')->where('status', 'open')->latest()->take(3)->get(),
        ]);
    }
}
