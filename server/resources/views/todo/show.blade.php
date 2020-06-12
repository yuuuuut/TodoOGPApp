@extends('layouts.app')

<?php 
$overDay = \App\Models\Todo::checkOverDueDate($todo->due_date);
?>

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
    期限内です
    {{ $todo->due_date }}
    @if ($todo->status == '0')
      <form action="{{ route('todos.update', ['id' => $todo->id]) }}" method="post">
        @csrf
        <input type="hidden" name="status" value="1">
        <button type="submit">投稿</button>
      </form>
    @endif
  @endif
@endsection