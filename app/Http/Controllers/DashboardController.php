<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ExchangeRequest;
use App\Models\Grant;
use App\Models\Investment;
use App\Models\Organization;
use App\Models\Patent;
use App\Models\Technology;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $trlDistribution = [
            'early' => Technology::whereBetween('trl', [1, 3])->count(),
            'prototype' => Technology::whereBetween('trl', [4, 6])->count(),
            'market' => Technology::whereBetween('trl', [7, 9])->count(),
        ];

        $stats = [];

        if ($user->role === User::ROLE_ADMIN || $user->role === 'agency') {
            $stats = [
                ['label' => 'Верификация', 'value' => User::where('verification_status', 'pending')->count(), 'delta' => 'очередь', 'hint' => 'пользователей', 'tone' => 'amber'],
                ['label' => 'Разработки', 'value' => Technology::count(), 'delta' => '+15%', 'hint' => 'всего в базе', 'tone' => 'emerald'],
                ['label' => 'Организации', 'value' => Organization::count(), 'delta' => '+2', 'hint' => 'НИИ и ВУЗы', 'tone' => 'sky'],
                ['label' => 'Инвестиции', 'value' => Investment::sum('amount'), 'delta' => 'TJS', 'hint' => 'всего', 'tone' => 'rose'],
            ];
        } elseif ($user->role === User::ROLE_SCIENTIST) {
            $myTechs = $user->technologies();
            $stats = [
                ['label' => 'Мои проекты', 'value' => $myTechs->count(), 'delta' => '+1', 'hint' => 'активных', 'tone' => 'emerald'],
                ['label' => 'Просмотры', 'value' => 1240, 'delta' => '+85', 'hint' => 'за месяц', 'tone' => 'sky'],
                ['label' => 'Интерес', 'value' => Investment::whereIn('technology_id', $myTechs->pluck('id'))->count(), 'delta' => 'запросов', 'hint' => 'от инвесторов', 'tone' => 'amber'],
                ['label' => 'Патенты', 'value' => Patent::whereIn('technology_id', $myTechs->pluck('id'))->count(), 'delta' => '', 'hint' => 'зарегистрировано', 'tone' => 'rose'],
            ];
        } elseif ($user->role === User::ROLE_INVESTOR) {
            $stats = [
                ['label' => 'Портфель', 'value' => $user->investments()->count(), 'delta' => 'проектов', 'hint' => 'активных', 'tone' => 'emerald'],
                ['label' => 'Вложено', 'value' => $user->investments()->sum('amount'), 'delta' => 'TJS', 'hint' => 'всего', 'tone' => 'sky'],
                ['label' => 'Избранное', 'value' => 8, 'delta' => '+2', 'hint' => 'сохранений', 'tone' => 'amber'],
                ['label' => 'ROI средний', 'value' => 18, 'delta' => '%', 'hint' => 'прогноз', 'tone' => 'rose'],
            ];
        } else {
            $stats = [
                ['label' => 'Разработки', 'value' => Technology::count(), 'delta' => '', 'hint' => 'доступно', 'tone' => 'emerald'],
                ['label' => 'Ученые', 'value' => User::where('role', 'scientist')->count(), 'delta' => '', 'hint' => 'в сети', 'tone' => 'sky'],
                ['label' => 'Гранты', 'value' => Grant::count(), 'delta' => '', 'hint' => 'открыто', 'tone' => 'amber'],
                ['label' => 'Конкурсы', 'value' => 4, 'delta' => '', 'hint' => 'активных', 'tone' => 'rose'],
            ];
        }

        return view('dashboard', [
            'stats' => $stats,
            'investmentTotal' => Investment::whereIn('status', ['approved', 'completed'])->sum('amount'),
            'organizationsCount' => Organization::count(),
            'verifiedOrganizationsCount' => Organization::where('verification_status', 'verified')->count(),
            'pendingScientistsCount' => User::where('role', 'scientist')->where('verification_status', 'pending')->count(),
            'pendingBusinessCount' => User::whereIn('role', ['business', 'investor', 'agency'])->where('verification_status', 'pending')->count(),
            'latestTechnologies' => Technology::with(['owner', 'organization'])->latest()->take(6)->get(),
            'grants' => Grant::query()->orderByRaw('deadline IS NULL, deadline ASC')->take(4)->get(),
            'requests' => ExchangeRequest::with('company')->latest()->take(5)->get(),
            'trlDistribution' => $trlDistribution,
            'user' => $user
        ]);
    }
}
