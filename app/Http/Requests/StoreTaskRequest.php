<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'min:3' , 'unique:tasks,title'],
            'description' => ['required','min:10', 'string'],
            'image' => ['nullable','array'],
            'image.*' => ['image','mimes:jpg,jpeg,png','max:5120'],
            'completed' => [ 'boolean' , 'default' => false],
            'due_date' => ['required', 'date' , 'after_or_equal:today'],
            'priority' => ['required', 'string', 'in:Low,Medium,High,Urgent'],
            'status' => ['required', 'string', 'in:To Do,In Progress,Completed'],
            'assigned_id' => ['required', 'exists:users,id'],
            'color' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ];
    }
}
