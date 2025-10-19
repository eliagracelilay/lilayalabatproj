<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class ProfileController extends BaseController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return view('layouts.admin-react', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

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
