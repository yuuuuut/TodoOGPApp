@extends('layouts.app')

@section('content')
<!-- php -->
@php
$tomorrow = new DateTime('+1 day');
$min_date = $tomorrow->format('Y-m-d');
@endphp
<!-- Main -->
<div class="main mt-4">
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
            <button type="submit" class="btn btn-outline-success" style="width: 304px;">作成</button>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 mb-2">
    <a href="{{ url("users/$user->nickname?incomplete=1") }}" class="btn btn-primary btn-sm">完了していないTodoのみ表示</a>
    <a href="{{ url("users/$user->nickname?incomplete=1") }}" class="btn btn-danger btn-sm">完了済のTodo一括削除</a>
</div>

@if($todos->count())
    <table class="table table-dark">
        <tr><th>やる事</th><th>期限</th><th>状態</th></tr>
            @foreach($todos as $todo)
                @component('components.todo_table', ['todo' => $todo])@endcomponent
            @endforeach
    </table>
@else
    Todoはありません。
@endif

@endsection