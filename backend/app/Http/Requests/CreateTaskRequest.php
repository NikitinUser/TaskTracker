<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task' => 'required|min:2|max:3000',
            'parentTask' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        $messages = [
            'task.required' => 'Введите задачу',
            'task.min:2' => 'Минимальная длина задачи - 2 символа',
            'task.max:3000' => 'Максимальная длина задачи - 3000 символов',
        ];
        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'errors' => $validator->errors(),
                'status' => true
            ],
            422
        ));
    }
}
