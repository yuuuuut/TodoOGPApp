@extends('layouts.app')

<?php 
$overDay = \App\Models\Todo::checkOverDueDate($todo->due_date);
?>

@if($overDay)
    @section('title', "Todo!!")
    @section('description', "次はきちんと期日までに終わらせましょう!!")
    @section('ogp', url("todos/{$todo->id}/ogp.png"))
@endif

@section('content')
  @if($overDay)
    期限外です
    {{ $todo->content }}
    <div class="d-flex justify-content-center">
      <img src="{{ url("todos/{$todo->id}/ogp.png") }}" class="img-fluid">
    </div>
  @else
    期限内です
    {{ $todo->due_date }}
  @endif
@endsection