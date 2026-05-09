@extends('layouts.user_layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title h3 mb-1"><i class="fas fa-pen me-2"></i>Edit Task #{{ $task->id }}</h1>
                <p class="text-muted mb-0">Update the saved task fields.</p>
            </div>
            <x-button variant="light" class="border" href="{{ route('tasks.show', $task->id) }}">Back</x-button>
        </div>

        <div class="app-surface p-4 p-lg-5">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            @foreach(['Low', 'Medium', 'High', 'Urgent'] as $priority)
                                <option value="{{ $priority }}" {{ old('priority', $task->priority) === $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            @foreach(['To Do', 'In Progress', 'Completed'] as $status)
                                <option value="{{ $status }}" {{ old('status', $task->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="completed" class="form-label d-block">Completed</label>
                        <div class="form-check mt-2">
                            <input type="checkbox" id="completed" name="completed" class="form-check-input" {{ old('completed', $task->completed) ? 'checked' : '' }}>
                            <label class="form-check-label" for="completed">Mark as done</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="creator_id" class="form-label">Creator</label>
                        <select id="creator_id" name="creator_id" class="form-select" required>
                            <option value="">Select creator</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('creator_id', $task->creator_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="assigned_id" class="form-label">Assigned To</label>
                        <select id="assigned_id" name="assigned_id" class="form-select" required>
                            <option value="">Select assignee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_id', $task->assigned_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label d-block">Color</label>
                        @php $colors = ['#1F3B67', '#2E5B9A', '#22C55E', '#F59E0B', '#EF4444', '#0EA5E9']; @endphp
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($colors as $color)
                                <label class="m-0">
                                    <input type="radio" class="d-none" name="color" value="{{ $color }}" {{ old('color', $task->color) === $color ? 'checked' : '' }}>
                                    <span class="d-inline-block rounded border border-2 {{ old('color', $task->color) === $color ? 'border-dark' : 'border-light' }}" style="width: 30px; height: 30px; background: {{ $color }};"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <x-button variant="primary" type="submit">Update Task</x-button>
                    <x-button variant="light" class="border" href="{{ route('tasks.show', $task->id) }}">Cancel</x-button>
                    <x-button variant="outline-danger" class="ms-auto" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Task</x-button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Are you sure you want to delete this task?</p>
                <p class="fw-semibold text-danger mb-0">{{ $task->title }}</p>
            </div>
            <div class="modal-footer">
                <x-button variant="light" class="border" data-bs-dismiss="modal">Cancel</x-button>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
