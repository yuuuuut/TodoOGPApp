@extends('layouts.app')

@section('content')
<?php 
$tomorrow = new DateTime('+1 day');
$min_date = $tomorrow->format('Y-m-d');
?>

    <div class="d-flex justify-content-center">
        @foreach($errors->all() as $message)
            {{ $message }}<br>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        <form action="{{ route('todos.store') }}" method="post">
            @csrf
            <input type="hidden" name="uid" value="{{ $user->uid }}">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Todo</span>
                </div>
                <input type="text" name="content" style="width: 247px;" placeholder="20文字以内...">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">期限</span>
                </div>
                    <input type="date" name="due_date" style="width: 250px;" min="{{ $min_date }}">
            </div>
            <button type="submit" class="btn btn-outline-success" style="width: 304px;">完了</button>
        </form>
    </div>

<a href="{{ url("users/$user->nickname?incomplete=1") }}">完了していないTodo</a><br>

@if($todos->count())
@foreach($todos as $todo)
<?php 
$overDay = \App\Models\Todo::checkOverDueDate($todo->due_date);
?>
{{ $todo->id }}
{{ $todo->content }}
{{ $todo->due_date }}
{{ $todo->status }}
@if ($todo->status == '0' && !$overDay)
<form action="{{ route('todos.update', ['id' => $todo->id]) }}" method="post">
@csrf
<input type="hidden" name="status" value="1">
<button type="submit">投稿</button>
</form>
@elseif ($todo->status == '0' && $overDay)
<button type="submit">期日外</button>
@endif
@if ($todo->status == '0' && $overDay)
<a href="/todos/{{ $todo->id }}">もっと見る</a>
@endif
<br>
@endforeach
@else
Todoはありません。
@endif

@endsection