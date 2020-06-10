@extends('layouts.app')

<?php $overDay = \App\Models\Todo::checkOverDueDate($todo->due_date) ?>

@if($overDay)
    @section('title', "Todo!!")
    @section('description', "次はきちんと期日までに終わらせましょう...")
    @section('ogp', url("todos/{$todo->id}/ogp.png"))
@endif

@section('content')
  @if($overDay)
    期限外です
    {{ $todo->content }}
  @else
    期限ないです
    {{ $todo->due_date }}
  @endif
@endsection