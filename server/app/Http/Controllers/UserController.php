<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;

class UserController extends Controller
{
    public function show(Request $request, $nickname)
    {
        $user  = User::where('nickname', $nickname)->firstOrFail();
        $query = Todo::where('user_id', $user->id);
        if ($request->input('incomplete')) {
            $query->where('status', '0')
                    ->orderBy('due_date', 'asc')
                    ->get();
        }
        $todos = $query->orderBy('id', 'desc')->get();
        return view('user.show', compact('user', 'todos'));
    }
}
