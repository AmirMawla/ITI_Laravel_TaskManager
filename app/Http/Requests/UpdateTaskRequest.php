<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $task = Task::find($this->route('id'));
        return [
            'title' => ['required', 'string', 'min:3' , Rule::unique('tasks')->ignore($task)],
            'description' => ['required', 'min:10', 'string'],
            'image' => ['nullable','array'],
            'image.*' => ['image','mimes:jpg,jpeg,png','max:5120' , 'nullable'],
            'completed' => [ 'boolean' , 'default' => false],
            'due_date' => ['nullable', 'date' , 'after_or_equal:today'],
            'priority' => ['required', 'string', 'in:Low,Medium,High,Urgent'],
            'status' => ['required', 'string', 'in:To Do,In Progress,Completed'],
            'assigned_id' => ['required', 'exists:users,id'],
            'color' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ];
    }
}
