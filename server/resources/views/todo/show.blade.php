@extends('layouts.app')

@section('title', "Todo!!")
@section('description', "次はきちんと期日までに終わらせましょう...")
@section('ogp', url("todos/{$todo->id}/ogp.png"))

@section('content')
{{ $todo->content }}
@endsection