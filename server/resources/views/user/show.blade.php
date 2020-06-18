@extends('layouts.app')

@section('content')
<!-- Main -->
<div class="main mt-4">
    <div class="d-flex justify-content-center">
        @foreach($errors->all() as $message)
            {{ $message }}<br>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        <form action="{{ route('todos.store') }}" method="post">
            @csrf
            <input type="hidden" name="uid" value="{{ $user->uid }}">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Todo</span>
                </div>
                <input type="text" name="content" style="width: 247px;" placeholder="20文字以内...">
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">期限</span>
                </div>
                    <input type="date" name="due_date" style="width: 250px;" min="{{ $min_date }}" max="2100-12-31">
            </div>
            <button type="submit" class="btn btn-outline-success" style="width: 304px;">作成</button>
        </form>
    </div>
</div>

<div class="d-flex justify-content-around mt-4 mb-2">
    <a href="{{ url("users/$user->nickname?incomplete=1") }}" class="btn btn-primary">未完了のTodoのみ表示</a>
    @if ($completed_todo)
    <!-- Modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">完了済のTodoを一括削除</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">削除しますか?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
                    <form action="{{ route('todos.allDelete') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
    @else
        <button type="button" class="btn btn-danger" disabled>完了済のTodoを一括削除</button>
    @endif
</div>

@if($todos->count())
    <table class="table table-dark">
        <tr><th>やる事</th><th>期限</th><th>状態</th></tr>
            @foreach($todos as $todo)
                @component('components.todo_table', ['todo' => $todo])@endcomponent
            @endforeach
    </table>
@else
    Todoはありません。
@endif

@endsection