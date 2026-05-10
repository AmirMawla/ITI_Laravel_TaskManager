<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\TaskImage;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadImageTrait;

class TasksController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $tasks = Task::withTrashed()->with('creator', 'assigned' , 'comments' ,'comments.user', 'images')->paginate(10);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', ['users' => $users]);
    }

    public function store(StoreTaskRequest $request)
    {

        $data = $request->validated();
        $data['creator_id'] = auth()->id();
        $data['completed'] = $data['completed'] ?? false;
        $task = Task::create(Arr::except($data, ['image']));

        foreach ($this->uploadImages($request, 'tasks') as $path) {
            $task->images()->create(['path' => $path]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(string $id)
    {
        $task = Task::with('comments.user', 'images')->find($id);
        $creator = User::find($task->creator_id);
        $assigned = User::find($task->assigned_id);
        return view('tasks.show', ['task' => $task , 'creator' => $creator, 'assigned' => $assigned]);
    }

    public function edit(string $id)
    {
        $task = Task::with('comments.user', 'images')->find($id);
        $users = User::all();
        return view('tasks.edit', ['task' => $task , 'users' => $users]);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $taskId = (int) $id;
        $task = Task::findorFail($taskId);
        $data = $request->validated();
        $task->update(Arr::except($data, ['image']));

        foreach ($this->uploadImages($request, 'tasks') as $path) {
            $task->images()->create(['path' => $path]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(string $id)
    {
        $task = Task::findorFail($id);

    
        foreach ($task->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function restore(string $id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.index');
    }

    public function forceDelete(string $id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->route('tasks.index');
    }
}
