<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,karyawan'],
            'photos' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ]);

        // Handle email verification if email has changed
        if ($validated['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $validated['email_verified_at'] = null;
        }

        // Handle photo upload
        if ($request->hasFile('photos')) {
            // Delete old photo if exists
            if ($user->photos) {
                Storage::disk('public')->delete($user->photos);
            }

            // Store new photo
            $path = $request->file('photos')->store('profile-photos', 'public');
            $validated['photos'] = $path;
        } else {
            // Keep existing photo if no new photo uploaded
            $validated['photos'] = $user->photos;
        }

        // Update user
        $user->update($validated);

        // Resend verification email if email changed
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete user's photo if exists
        if ($user->photos) {
            Storage::disk('public')->delete($user->photos);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}