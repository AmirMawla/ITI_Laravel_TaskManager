<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadImageTrait;


class TaskController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $tasks = Task::with('creator', 'assigned' , 'comments' ,'comments.user', 'images')->paginate(10);

        return TaskResource::collection($tasks);
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

        return response()->json(['message' => 'Task created successfully.', 'task' => new TaskResource($task)], 201);
    }

    public function show(string $id)
    {
        $task = Task::with('comments.user', 'creator', 'assigned', 'images')->find($id);
        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $taskId = (int) $id;
        $task = Task::findorFail($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
        $data = $request->validated();
        $task->update(Arr::except($data, ['image']));

        foreach ($this->uploadImages($request, 'tasks') as $path) {
            $task->images()->create(['path' => $path]);
        }

        return response()->json(['message' => 'Task updated successfully.', 'task' => new TaskResource($task)]);
    }

    public function destroy(string $id)
    {
        $task = Task::findorFail($id);
          
        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
    
        foreach ($task->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }

    
}
