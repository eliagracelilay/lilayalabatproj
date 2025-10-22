<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use App\Models\AdminProfile;

class ProfileController extends BaseController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Ensure admin profile exists for the logged-in user
        $profile = $user->adminProfile()->firstOrCreate([], [
            'first_name' => null,
            'last_name' => null,
            'phone' => null,
        ]);
        return view('layouts.admin-react', [
            'user' => $user,
            'adminProfile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
        ]);

        // Update user email (and legacy name string for compatibility)
        $first = $validated['first_name'] ?? optional($user->adminProfile)->first_name;
        $last = $validated['last_name'] ?? optional($user->adminProfile)->last_name;
        $fullName = trim(($first ?? '') . ' ' . ($last ?? ''));
        $user->update([
            'email' => $validated['email'] ?? $user->email,
            'name' => $fullName !== '' ? $fullName : ($user->name ?? ''),
        ]);

        // Update or create admin profile (first_name, last_name, phone)
        $profile = $user->adminProfile()->firstOrCreate([]);
        $profile->update([
            'first_name' => $validated['first_name'] ?? $profile->first_name,
            'last_name' => $validated['last_name'] ?? $profile->last_name,
            'phone' => $validated['phone'] ?? $profile->phone,
        ]);

        // Build response payload
        $responseUser = [
            'id' => $user->id,
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'name' => $fullName !== '' ? $fullName : ($user->name ?? ''),
            'email' => $user->email,
            'phone' => $profile->phone,
            'created_at' => $user->created_at,
        ];

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['success' => true, 'user' => $responseUser]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function archive(Request $request)
    {
        $user = Auth::user();
        
        // Archive (soft delete) the user
        $user->delete();
        
        // Log out the user after archiving
        Auth::logout();
        
        return redirect('/')->with('success', 'Profile archived successfully');
    }
}
