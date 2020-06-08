<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;

class UserController extends Controller
{
    public function show($nickname)
    {
        $user  = User::where('nickname', $nickname)->firstOrFail();
        $todos = Todo::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('user.show', compact('user', 'todos'));
    }
}
