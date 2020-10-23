<div class="card">
    <div class="card-header">
        <i class="fa fa-align-justify"></i>{{ __('Tasks') }}</div>
    <div class="card-body">
        @if(count($tasks) == 0)
            <i class="fa fa-align-justify"></i>{{ __('No Tasks yet') }}
        @else
        <table class="table table-responsive-sm table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>URL</th>
                <th>Status</th>
                <th>Last run</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td><strong>{{ $task->name }}</strong></td>
                    <td>{{ $task->url }}</td>
                    <td>
                        <span class="{{ $task->status->class }}">
                            {{ $task->status->name }}
                        </span>
                    </td>
                    <td>{{ $task->lastRunTime }}</td>
                    <td>
                        <a href="{{ url('/projects/' . $project->id . '/tasks/'.$task->id.'/edit') }}" class="btn btn-block btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('tasks.destroy', ['project'=> $project, 'task' => $task]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-block btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endempty
    </div>
</div>
