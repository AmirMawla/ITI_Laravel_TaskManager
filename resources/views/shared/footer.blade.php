
<footer class="bg-white border-top mt-auto">
    <div class="container py-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <p class="mb-0 text-muted small">
            <i class="fas fa-check-circle text-success me-1"></i>{{ date('Y') }} Task Manager
        </p>
        <div class="d-flex align-items-center gap-3 small">
            <a href="{{ route('tasks.index') }}" class="text-decoration-none text-secondary">All Tasks</a>
            <a href="{{ route('tasks.create') }}" class="text-decoration-none text-secondary">Create Task</a>
        </div>
    </div>
</footer>
