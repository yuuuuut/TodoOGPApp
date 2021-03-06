<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTodo;
use App\Models\Todo;
use App\Models\User;
use Auth;

class TodoController extends Controller
{
    public function show(Todo $todo)
    {
        $this->checkAbort($todo);
        return view('todo.show', compact('todo'));
    }

    public function store(CreateTodo $request)
    {
        $user = User::whereUser();
        $todo = new Todo();
        $todo->user_id  = Auth::id();
        $todo->content  = $request->input('content');
        $todo->due_date = $request->input('due_date');
        $todo->save();
        return redirect("users/$user->nickname");
    }

    public function update(Request $request, int $id)
    {
        $user = User::whereUser();
        $todo = Todo::findOrFail($id);
        $todo->status = $request->status;
        $todo->save();
        return redirect("users/$user->nickname");
    }

    public function delete(Todo $todo)
    {
        $user = Auth::user();
        Todo::find($todo->id)->delete();
        return redirect("users/$user->nickname");
    }

    public function allDelete()
    {
        $user = Auth::user();
        Todo::where('user_id', $user->id)
            ->where('status', '1')
            ->delete();
        return redirect("users/$user->nickname");
    }

    public function ogp($id)
    {
        $todo  = Todo::findOrFail($id);
        $image = $todo->generateOgp($id);
        return response($image, 200)
            ->header('Content-Type', 'image/png');
    }

    private function checkAbort($todo)
    {
        if ($todo->status == '1') {
            abort(403);
        }
    }
}
