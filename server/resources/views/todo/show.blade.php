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
    <div class="d-flex justify-content-center mt-5">
      <div id="loading" class="spinner-border text-success" role="status"><span class="sr-only">Loading...</span></div>
      <img src="{{ url("todos/{$todo->id}/ogp.png") }}" class="img-fluid">
    </div>
    <!-- Twitterシェア -->
    <div class="d-flex justify-content-center mt-5">
      <h5>\ Twitterにシェアして反省しましょう!! /</h5>
    </div>
    <div class="d-flex justify-content-center mt-2">
      <a href='https://twitter.com/share?ref_src=twsrc%5Etfw&text=期限過ぎちゃった!!%20%23Todoとど' class="twitter-share-button" data-show-count="false">Tweet</a>
    </div>
    <!-- 削除ボタン -->
    <div class="d-flex justify-content-center mt-4">
      <form action="{{ route('todos.delete', ['todo' => $todo->id]) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-danger">反省したので削除する</button>
      </form>
    </div>
  @else
    <h4>期限内です</h4>
  @endif
@endsection

@section('scripts')
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script>
      window.onload = function () {
        $('#loading').css("display", "none");
      };
    </script>
@endsection