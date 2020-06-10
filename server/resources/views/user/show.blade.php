@extends('layouts.app')

@section('content')
<h1>{{ $user->nickname }}</h1>

@foreach($errors->all() as $message)
  {{ $message }}
@endforeach

{{ Form::open(['url' => url('todos')]) }}
  {{ Form::hidden('uid', $user->uid) }}
  {{ Form::textarea('content') }}
  {{ Form::date('due_date') }}
  {{ Form::Submit('完了', ['class'=>'todo__createButton']) }}
{{ Form::close() }}

@if($todos->count())
  @foreach($todos as $todo)
    {{ $todo->id }}
    {{ $todo->content }}
    {{ $todo->due_date }}
    <a href="/todos/{{ $todo->id }}">もっと見る</a>
  @endforeach
@else
  Todoはありません。
@endif

@endsection