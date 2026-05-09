@extends('layouts.user_layout')

@section('content')

<div class="row align-items-stretch g-4 mb-4">
    <div class="col-12">
        <div class="app-surface p-4 p-lg-5 position-relative overflow-hidden">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge text-bg-light border">Task #{{ $task->id }}</span>
                        <span class="badge text-bg-primary">{{ $task->status }}</span>
                    </div>
                    <h1 class="h2 mb-2">{{ $task->title }}</h1>
                    <p class="text-muted mb-0">{{ $task->description }}</p>
                </div>

                <div class="d-flex gap-2">
                    <x-button variant="primary" icon="pen" href="{{ route('tasks.edit', $task->id) }}">Edit</x-button>
                    <x-button variant="light" class="border" href="{{ route('tasks.index') }}">Back</x-button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="app-surface p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Task Summary</h2>
                <span class="small text-muted">Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="small text-muted mb-1">Priority</div>
                        <div class="fw-semibold">{{ $task->priority }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="small text-muted mb-1">Due Date</div>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <div class="small text-muted mb-1">Completed</div>
                        <div class="fw-semibold">{{ $task->completed ? 'Yes' : 'No' }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="small text-muted mb-1">Creator</div>
                        <div class="fw-semibold">{{ $creator->name }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100">
                        <div class="small text-muted mb-1">Assigned</div>
                        <div class="fw-semibold">{{ $assigned->name }}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border rounded p-3 h-100 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="small text-muted mb-1">Color</div>
                            <div class="fw-semibold">{{ $task->color }}</div>
                        </div>
                        <span class="rounded-circle border" style="width: 28px; height: 28px; background: {{ $task->color }};"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="app-surface p-4 mb-4">
            <h2 class="h5 mb-3">Task Details</h2>
            <div class="d-grid gap-3">
                <div>
                    <div class="small text-muted mb-1">Status</div>
                    <span class="badge text-bg-primary px-3 py-2">{{ $task->status }}</span>
                </div>
                <div>
                    <div class="small text-muted mb-1">Priority</div>
                    <span class="badge text-bg-secondary px-3 py-2">{{ $task->priority }}</span>
                </div>
                <div>
                    <div class="small text-muted mb-1">Completion</div>
                    <div class="fw-semibold">{{ $task->completed ? 'Completed' : 'Not completed' }}</div>
                </div>
                <div>
                    <div class="small text-muted mb-1">Created</div>
                    <div class="fw-semibold">{{ $task->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="small text-muted mb-1">Updated</div>
                    <div class="fw-semibold">{{ $task->updated_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
