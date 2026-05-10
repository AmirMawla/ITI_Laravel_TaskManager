@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title h3 mb-0"><i class="fas fa-plus-circle me-2"></i>Create Task</h1>
            <x-button variant="light" class="border" href="{{ route('tasks.index') }}">Back</x-button>
        </div>

        <div class="app-surface p-4 p-lg-5">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    </div>
                    @error('title')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror

                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-select" id="priority" name="priority" required>
                            @foreach(['Low', 'Medium', 'High', 'Urgent'] as $priority)
                                <option value="{{ $priority }}" {{ old('priority') === $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('priority')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            @foreach(['To Do', 'In Progress', 'Completed'] as $status)
                                <option value="{{ $status }}" {{ old('status', 'To Do') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('status')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                    <div class="col-md-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                    </div>
                    @error('due_date')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                    <div class="col-md-3">
                        <label for="creator_id" class="form-label">Creator</label>
                        <select class="form-select" id="creator_id" name="creator_id" required disabled>
                            <option value="">Select user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ auth()->id() == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('creator_id')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror

                    <div class="col-md-3">
                        <label for="assigned_id" class="form-label">Assigned To</label>
                        <select class="form-select" id="assigned_id" name="assigned_id" required>
                            <option value="">Select user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('assigned_id')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror
                    <div class="col-md-6">
                        <label class="form-label">Color</label>
                        @php $colors = ['#1F3B67', '#2E5B9A', '#22C55E', '#F59E0B', '#EF4444', '#0EA5E9']; @endphp
                        <div class="d-flex flex-wrap gap-2" id="color-options">
                            @foreach($colors as $color)
                                <label class="m-0">
                                    <input type="radio" class="d-none" name="color" value="{{ $color }}" {{ old('color', '#1F3B67') === $color ? 'checked' : '' }}>
                                    <span class="d-inline-block rounded border" style="width: 30px; height: 30px; background: {{ $color }};"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @error('color')
                        <div class="col-12">
                            <div class="alert alert-danger">{{ $message }}</div>
                        </div>
                    @enderror

                    <div class="col-md-6">
                        <label for="image" class="form-label">Images (jpg, png) — you can select multiple</label>
                        <input type="file" class="form-control" id="image" name="image[]" accept="image/png, image/jpeg" multiple>
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                        @error('image.*')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="d-flex gap-2 mt-4">
                    <x-button variant="primary" type="submit">Create Task</x-button>
                    <x-button variant="light" class="border" href="{{ route('tasks.index') }}">Cancel</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
