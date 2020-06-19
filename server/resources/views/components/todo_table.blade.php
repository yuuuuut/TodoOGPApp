<!-- php -->
@php
$over_day    = App\Models\Todo::checkOverDueDate($todo->due_date);
$danger_todo = App\Models\Todo::dangerTodoBool($todo->status, $over_day);
@endphp
<!-- Main -->
<div class="main">
    @if ($danger_todo)
        <tr><td>{{ $todo->content }}
        <br><a href="/todos/{{ $todo->id }}">反省する</a></td>
    @else
        <tr><td>{{ $todo->content }}</td>
    @endif
    <td>{{ $todo->due_date }}</td>

    @if ($todo->status == '0' && !$over_day)
    <!-- Modal -->
        <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-sm">未完了</button></td>
        <div class="modal fade bd-example-modal-sm mt-5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="{{ route('todos.update', ['id' => $todo->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="status" value="1">
                        <button type="submit" class="btn btn-success">完了済にする</button>
                    </form>
                </div>
            </div>
        </div>
    <!-- Modal end -->
    @elseif ($danger_todo)
        <td><button type="submit" class="btn btn-danger">期限外</button></td>
    @else
        <td><button type="submit" class="btn btn-primary">完了済</button></td>
    @endif
</div>