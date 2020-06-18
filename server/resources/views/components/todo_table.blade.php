<!-- php -->
@php
$over_day    = App\Models\Todo::checkOverDueDate($todo->due_date);
$danger_todo = App\Models\Todo::dangerTodoBool($todo->status, $over_day);
@endphp
<!-- Main -->
<div class="main">
    @if ($danger_todo)
        <tr><td>{{ $todo->content }}
        <a href="/todos/{{ $todo->id }}">反省する</a></td>
    @else
        <tr><td>{{ $todo->content }}</td>
    @endif
    <td>{{ $todo->due_date }}</td>

    @if ($todo->status == '0' && !$over_day)
        <form action="{{ route('todos.update', ['id' => $todo->id]) }}" method="post">
            @csrf
            <input type="hidden" name="status" value="1">
            <td><button type="submit" class="btn btn-warning">未完了</button></td>
        </form>
    @elseif ($danger_todo)
        <td><button type="submit" class="btn btn-danger">期日外</button></td>
    @else
        <td><button type="submit" class="btn btn-primary">完了</button></td>
    @endif
</div>