<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RewriteTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'            => 'required|integer',
            'task'          => 'required|min:3|max:900|regex:/^[A-Za-z А-Яа-яёЁ 0-9 ;.,-=+]+$/ui',
            'priorityTask'  => 'required|integer|min:0|max:3',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'task.required' => 'Чтобы добавить задачу - ее нужно ввести',
            'task.min:3' => 'Минимальная длина задачи - 3 символа',
            'task.max:900' => 'Максимальная длина задачи - 400 символов',
            'task.regex' => 'Допустимые символы для задачи: A-Za-z А-Яа-яёЁ 0-9 ;.,-=+',

            'priorityTask.required' => 'Необходимо выбрать приоритетность задачи',
            'priorityTask.integer' => 'Приоритетность задачи должна быть целым числом',
            'priorityTask.min:0' => 'Приоритетность задачи начинает от 0 (низкая)',
            'priorityTask.max:900' => 'Максимальная приоритетность задачи - 2 (высокая)',

            'id.required' => 'Идентификатор задачи должен быть указан',
            'id.integer' => 'Идентификатор задачи должен быть целым числом',
        ];
        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(),'status' => true], 422));
    }
}
