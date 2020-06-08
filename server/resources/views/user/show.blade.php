@extends('layouts.app')

@section('content')
<h1>{{ $user->nickname }}</h1>

{{ Form::open(['url' => url('todos')]) }}
  {{ Form::hidden('uid', $user->uid) }}
  {{ Form::textarea('content') }}
  {{ Form::date('due_date') }}
  {{ Form::Submit('完了') }}
{{ Form::close() }}
@endsection