<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTodo;
use App\Models\Todo;
use App\Models\User;
use Auth;

class TodoController extends Controller
{
    public function store(CreateTodo $request)
    {
        $user = User::where('uid', $request->input('uid'))->firstOrFail();
        $todo = new Todo();
        $todo->user_id  = Auth::id();
        $todo->content  = $request->input('content');
        $todo->due_date = $request->input('due_date');
        $todo->save();

        return redirect("users/$user->nickname");
    }
}
