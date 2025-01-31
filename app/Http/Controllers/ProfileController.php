<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => __('The provided password does not match your current password.')])
                    ->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', __('Profile updated successfully.'));
    }

    public function disconnectSocialAccount($provider)
    {
        $user = auth()->user();
        
        $socialAccount = $user->socialAccounts()
            ->where('provider', $provider)
            ->first();

        if ($socialAccount) {
            $socialAccount->delete();
            return back()->with('success', __(':provider account disconnected successfully.', ['provider' => ucfirst($provider)]));
        }

        return back()->with('error', __('Social account not found.'));
    }
}