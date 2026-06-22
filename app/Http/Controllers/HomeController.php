<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRequest;
use App\Models\Grant;
use App\Models\Investment;
use App\Models\Technology;
use App\Models\User;

class HomeController extends Controller
{
    public function __invoke()
    {
        if (session()->has('locale')) {
            \App::setLocale(session()->get('locale'));
        }
        return view('welcome', [
            'stats' => [
                'projects' => Technology::count(),
                'scientists' => User::where('role', 'scientist')->count(),
                'investors' => User::where('role', 'investor')->count(),
                'investments' => Investment::whereIn('status', ['approved', 'completed'])->sum('amount'),
            ],
            'latestTechnologies' => Technology::with(['owner', 'organization'])->latest()->take(6)->get(),
            'grants' => Grant::query()->orderByRaw('deadline IS NULL, deadline ASC')->take(3)->get(),
            'requests' => ExchangeRequest::with('company')->where('status', 'open')->latest()->take(3)->get(),
        ]);
    }
}
