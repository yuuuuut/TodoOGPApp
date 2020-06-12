@extends('layouts.app')

@section('content')
<?php 
$count = \App\Models\Todo::checkLimitDayOneTodo();
?>

@if ($count)
  期日が明日までのTodoが{{ $count }}件あります。
@endif

<h1>{{ $user->nickname }}</h1>

@foreach($errors->all() as $message)
  {{ $message }}
@endforeach

{{ Form::open(['route' => 'todos.store']) }}
  {{ Form::hidden('uid', $user->uid) }}
  {{ Form::textarea('content') }}
  {{ Form::date('due_date') }}
  {{ Form::Submit('完了', ['class'=>'todo__createButton']) }}
{{ Form::close() }}

<a href="{{ url("users/$user->nickname?incomplete=1") }}">完了していないTodo</a><br>

@if($todos->count())
  @foreach($todos as $todo)
    {{ $todo->id }}
    {{ $todo->content }}
    {{ $todo->due_date }}
    {{ $todo->status }}
    <a href="/todos/{{ $todo->id }}">もっと見る</a>
    <br>
  @endforeach
@else
  Todoはありません。
@endif

@endsection