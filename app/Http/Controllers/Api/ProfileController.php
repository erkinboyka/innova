<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get public profile by scientist/investor ID.
     */
    public function show(User $user)
    {
        $user->load(['technologies', 'organization', 'investments']);
        
        // Hide sensitive info
        $user->makeHidden(['email', 'email_verified_at', 'password', 'remember_token', 'google_id']);
        
        return response()->json($user);
    }

    /**
     * Update profile (Authenticated).
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'profile_theme' => 'nullable|array',
            'publications' => 'nullable|array',
            'awards' => 'nullable|array',
            'expertise' => 'nullable|array',
        ]);

        $user->update($validated);

        return response()->json($user);
    }
}
