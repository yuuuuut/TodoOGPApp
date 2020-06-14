@extends('layouts.app')

@section('content')
<?php 
list($todo_count, $todo_get) = \App\Models\Todo::checkLimitDayTomorrowTodo();
?>

@if ($todo_count)
  期日が明日までのTodoが{{ $todo_count }}件あります。<br>
  @foreach($todo_get as $todo)
    {{ $todo->id }}
    {{ $todo->content }}
    {{ $todo->due_date }}
    {{ $todo->status }}
    <a href="/todos/{{ $todo->id }}">もっと見る</a>
    <br>
  @endforeach
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