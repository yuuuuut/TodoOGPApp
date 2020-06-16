@if (Auth::check())
<!-- php -->
@php
list($todo_count, $todo_get) = \App\Models\Todo::checkLimitDayTomorrowTodo(Auth::user());
@endphp
<!-- Main -->
<div class="main">
    <div class="d-flex justify-content-center mt-5">
        <img src="{{ Auth::user()->avatar }}">
    </div>
    <div class="d-flex justify-content-center">
        <div class="flex-column">
            <h2 class="mt-3">{{ Auth::user()->name }}<br>さんのマイページ</h2>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary btn-lg mt-2 mb-2" href="/users/{{ Auth::user()->nickname }}">Todo一覧・作成</a>
            </div>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="d-flex justify-content-center">
            <h2 class="text-muted">【お知らせ】</h2>
        </div>
        @if ($todo_count)
            <div class="d-flex justify-content-center"> 
                <h4 class="text-danger">期日が明日までのTodoが{{ $todo_count }}件あります</h4>
            </div>
            @if($todo_get->count())
                <table class="table table-dark">
                    <tr><th>やる事</th><th>期限</th><th>状態</th></tr>
                        @foreach($todo_get as $todo)
                            @component('components.todo_table', ['todo' => $todo])@endcomponent
                        @endforeach
                </table>
            @endif
        @else
            <div class="d-flex justify-content-center"> 
                <h4 class="mt-4">お知らせはありません</h4>
            </div>
        @endif
    </div>
</div>
@else
    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
@endif