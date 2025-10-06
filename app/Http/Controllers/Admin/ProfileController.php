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
        return view('admin.profile', [
            'user' => $user,
        ]);
    }
}
