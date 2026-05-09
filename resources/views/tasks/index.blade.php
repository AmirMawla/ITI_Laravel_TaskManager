@extends('layouts.user_layout')

@section('content')
@php
    $totalTasks = $tasks->count();
    $completedTasks = $tasks->where('status', 'Completed')->count();
    $inProgressTasks = $tasks->where('status', 'In Progress')->count();
    $todoTasks = $tasks->where('status', 'To Do')->count();
@endphp
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title h2 mb-1">
            <i class="fas fa-table-list me-2"></i>Tasks
        </h1>
        <p class="text-muted mb-0">Simple overview for all tasks.</p>
    </div>
    <x-button variant="primary" icon="plus" href="{{ route('tasks.create') }}">New Task</x-button>
</div>

@if(count($tasks) > 0)
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="app-surface p-3 h-100">
                <div class="small text-muted">Total</div>
                <div class="h4 mb-0">{{ $totalTasks }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-surface p-3 h-100">
                <div class="small text-muted">Completed</div>
                <div class="h4 mb-0 text-success">{{ $completedTasks }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-surface p-3 h-100">
                <div class="small text-muted">In Progress</div>
                <div class="h4 mb-0 text-warning">{{ $inProgressTasks }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-surface p-3 h-100">
                <div class="small text-muted">To Do</div>
                <div class="h4 mb-0 text-primary">{{ $todoTasks }}</div>
            </div>
        </div>
    </div>

    <div class="app-surface overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Creator</th>
                        <th>Assigned</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr @if($task->trashed()) class="table-danger opacity-50" @endif>
                            <td class="fw-semibold">#{{ $task->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $task->title }}</div>
                                <div class="small text-muted">Created: {{ $task->created_at->format('M d, Y') }}</div>
                                @if($task->trashed())
                                    <span class="badge text-bg-danger mt-1">Deleted</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $priorityClass = 'text-bg-secondary';
                                    if ($task->priority === 'Low') $priorityClass = 'text-bg-success';
                                    if ($task->priority === 'Medium') $priorityClass = 'text-bg-warning';
                                    if ($task->priority === 'High') $priorityClass = 'text-bg-danger';
                                    if ($task->priority === 'Urgent') $priorityClass = 'text-bg-dark';
                                @endphp
                                <span class="badge {{ $priorityClass }}">{{ $task->priority }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = 'text-bg-primary';
                                    if ($task->status === 'In Progress') $statusClass = 'text-bg-warning';
                                    if ($task->status === 'Completed') $statusClass = 'text-bg-success';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $task->status }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                            <td>{{ $task->creator_id }}</td>
                            <td>{{ $task->assigned_id }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Task actions">
                                    @if(!$task->trashed())
                                        <x-button variant="outline-secondary" size="sm" icon="eye" href="{{ route('tasks.show', $task->id) }}" title="View" class="btn-group-item"></x-button>
                                        <x-button variant="outline-primary" size="sm" icon="pen" href="{{ route('tasks.edit', $task->id) }}" title="Edit" class="btn-group-item"></x-button>
                                        <x-button variant="outline-danger" size="sm" icon="trash" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}" class="btn-group-item"></x-button>
                                    @else
                                        <x-button variant="outline-success" size="sm" icon="undo" title="Restore" data-bs-toggle="modal" data-bs-target="#restoreModal{{ $task->id }}" class="btn-group-item"></x-button>
                                        <x-button variant="outline-danger" size="sm" icon="xmark" title="Force Delete" data-bs-toggle="modal" data-bs-target="#forceDeleteModal{{ $task->id }}" class="btn-group-item"></x-button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach($tasks as $task)
        @if(!$task->trashed())
        <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">
                            <i class="fas fa-triangle-exclamation text-danger me-2"></i>Delete Task
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-1">Are you sure you want to delete:</p>
                        <p class="fw-semibold text-danger mb-0">{{ $task->title }}</p>
                    </div>
                    <div class="modal-footer">
                        <x-button variant="light" class="border" data-bs-dismiss="modal">Cancel</x-button>
                        <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit">Delete</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="modal fade" id="restoreModal{{ $task->id }}" tabindex="-1" aria-labelledby="restoreModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restoreModalLabel{{ $task->id }}">
                            <i class="fas fa-rotate-left text-success me-2"></i>Restore Task
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-1">Restore this deleted task?</p>
                        <p class="fw-semibold text-primary mb-0">{{ $task->title }}</p>
                    </div>
                    <div class="modal-footer">
                        <x-button variant="light" class="border" data-bs-dismiss="modal">Cancel</x-button>
                        <form action="{{ route('tasks.restore', ['id' => $task->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            <x-button variant="success" type="submit">Restore</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="forceDeleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="forceDeleteModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forceDeleteModalLabel{{ $task->id }}">
                            <i class="fas fa-trash text-danger me-2"></i>Permanently Delete Task
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-1 text-danger fw-semibold">⚠️ This action cannot be undone!</p>
                        <p class="mb-1">Permanently delete this task?</p>
                        <p class="fw-semibold text-danger mb-0">{{ $task->title }}</p>
                    </div>
                    <div class="modal-footer">
                        <x-button variant="light" class="border" data-bs-dismiss="modal">Cancel</x-button>
                        <form action="{{ route('tasks.forceDelete', ['id' => $task->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit">Permanently Delete</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    </div>


    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>

@else
    <div class="app-surface text-center p-5">
        <i class="fas fa-inbox fs-1 text-secondary mb-3"></i>
        <h2 class="h4">No tasks yet</h2>
        <p class="text-muted">Create your first task to get started.</p>
        <x-button variant="primary" icon="plus" href="{{ route('tasks.create') }}">Create Task</x-button>
    </div>
@endif

@endsection
