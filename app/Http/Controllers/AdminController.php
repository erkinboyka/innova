<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrantRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\Grant;
use App\Models\Organization;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'organizations' => Organization::withCount(['members', 'technologies'])
                ->latest()
                ->take(10)
                ->get(),
            'pendingUsers' => User::with('organization')
                ->where('verification_status', 'pending')
                ->latest()
                ->take(12)
                ->get(),
            'scientists' => User::where('role', 'scientist')
                ->with('organization')
                ->latest()
                ->take(12)
                ->get(),
            'grants' => Grant::latest()->take(8)->get(),
            'stats' => [
                'organizations' => Organization::count(),
                'verified_organizations' => Organization::where('verification_status', 'verified')->count(),
                'pending_users' => User::where('verification_status', 'pending')->count(),
                'technologies' => Technology::count(),
            ],
        ]);
    }

    public function storeOrganization(StoreOrganizationRequest $request): RedirectResponse
    {
        Organization::create([
            ...$request->validated(),
            'verification_status' => 'verified',
            'verified_at' => now(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Организация добавлена и подтверждена.');
    }

    public function verifyOrganization(Organization $organization): RedirectResponse
    {
        $organization->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Организация подтверждена.');
    }

    public function storeGrant(StoreGrantRequest $request): RedirectResponse
    {
        Grant::create($request->validated());

        return redirect()
            ->route('admin.index')
            ->with('success', 'Грант или программа добавлены.');
    }

    public function assignScientist(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'scientist', 404);

        $validated = $request->validate([
            'organization_id' => ['required', 'exists:organizations,id'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $organization = Organization::findOrFail($validated['organization_id']);

            $user->update([
                'organization_id' => $organization->id,
                'organization_name' => $organization->name,
                'position' => $validated['position'] ?? $user->position,
                'verification_status' => 'verified',
                'verification_type' => 'admin_assigned',
                'verified_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.index')
            ->with('success', 'Учёный привязан к организации и верифицирован.');
    }

    public function verifyUser(User $user): RedirectResponse
    {
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Пользователь верифицирован.');
    }

    public function rejectUser(User $user): RedirectResponse
    {
        $user->update([
            'verification_status' => 'rejected',
            'verified_at' => null,
        ]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Пользователь отклонён.');
    }
}
