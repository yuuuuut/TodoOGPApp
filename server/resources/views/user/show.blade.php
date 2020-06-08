@extends('layouts.app')

@section('content')
<h1>{{ $user->nickname }}</h1>

{{ Form::open(['url' => url('todos')]) }}
  {{ Form::hidden('uid', $user->uid) }}
  {{ Form::textarea('content') }}
  {{ Form::date('due_date') }}
  {{ Form::Submit('完了') }}
{{ Form::close() }}

@if($todos->count())
  @foreach($todos as $todo)
    {{ $todo->id }}
    {{ $todo->content }}
    {{ $todo->due_date }}
  @endforeach
@else
  Todoはありません。
@endif

@endsection