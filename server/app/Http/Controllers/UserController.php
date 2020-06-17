<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use Auth;

class UserController extends Controller
{
    public function show(Request $request, $nickname)
    {
        $user  = User::where('nickname', $nickname)->firstOrFail();
        $completed_todo = Todo::finishTodo($user)->exists();

        $query = Todo::where('user_id', $user->id);
        if ($request->input('incomplete')) {
            $query = Todo::incomplete($user);
        }
        $todos = $query->orderBy('id', 'desc')->get();
        return view('user.show', compact('user', 'todos', 'completed_todo'));
    }
}
