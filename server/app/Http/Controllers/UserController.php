<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show($nickname)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        return view('user.show', compact('user'));
    }
}
