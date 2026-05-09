<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TasksController extends Controller
{

    public function index()
    {
        $tasks = Task::withTrashed()->paginate(10);
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        $users = User::all();
        return view('tasks.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        Task::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'completed' => $request->boolean('completed'),
            'due_date' => $request['due_date'],
            'priority' => $request['priority'],
            'status' => $request['status'] ?? 'To Do',
            'creator_id' => $request['creator_id'],
            'assigned_id' => $request['assigned_id'],
            'color' => $request['color'] ?? '#1F3B67',
        ]);
        return redirect()->route('tasks.index');
    }

    public function show(string $id)
    {
        $task = Task::find($id);
        $creator = User::find($task->creator_id);
        $assigned = User::find($task->assigned_id);
        return view('tasks.show', ['task' => $task , 'creator' => $creator, 'assigned' => $assigned]);
    }

    public function edit(string $id)
    {
        $task = Task::find($id);
        $users = User::all();
        return view('tasks.edit', ['task' => $task , 'users' => $users]);
    }

    public function update(Request $request, string $id)
    {
        $taskId = (int) $id;
        $task = Task::findorFail($taskId);
        $task->update([
            "title" => $request['title'] ?? $task['title'],
            "description" => $request['description'] ?? $task['description'],
            "completed" => $request->has('completed') ? $request->boolean('completed') : $task['completed'],
            "due_date" => $request['due_date'] ?? $task['due_date'],
            "priority" => $request['priority'] ?? $task['priority'],
            "status" => $request['status'] ?? $task['status'],
            "assigned_id" => $request['assigned_id'] ?? $task['assigned_id'],
            "color" => $request['color'] ?? $task['color'],
            "updated_at" => now(),
        ]);
        
        return redirect()->route('tasks.index');
    }

    public function destroy(string $id)
    {
        $task = Task::findorFail($id);
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
