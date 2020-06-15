@if (Auth::check())
<!-- 変数 -->
<?php 
list($todo_count, $todo_get) = \App\Models\Todo::checkLimitDayTomorrowTodo();
?>
<!-- Main -->
<div class="main">
    <div class="d-flex justify-content-center mt-5">
        <img src="{{ Auth::user()->avatar }}">
    </div>
    <div class="d-flex justify-content-center">
        <div class="flex-column">
            <h2 class="mt-3">{{ Auth::user()->name }}さんのマイページ</h2>
            <div class="d-flex justify-content-center">
                <a class="mt-2" href="/users/{{ Auth::user()->nickname }}">Todo一覧・作成</a>
            </div>
        </div>
    </div>
    @if ($todo_count)
    期日が明日までのTodoが{{ $todo_count }}件あります。<br>
    @foreach($todo_get as $todo)
        {{ $todo->id }}
        {{ $todo->content }}
        {{ $todo->due_date }}
        {{ $todo->status }}
        <a href="/todos/{{ $todo->id }}">もっと見る</a>
        <br>
    @endforeach
    @endif
</div>
@else
<a class="nav-link" href="{{ route('login') }}">ログイン</a>
@endif