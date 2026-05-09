<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('tasks.index') }}">
            <i class="fas fa-tasks me-2"></i>Task Manager
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('tasks.index') }}">
                        <i class="fas fa-list me-1"></i>All Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active fw-semibold text-primary' : '' }}" href="{{ route('tasks.create') }}">
                        <i class="fas fa-plus-circle me-1"></i>Create Task
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>




