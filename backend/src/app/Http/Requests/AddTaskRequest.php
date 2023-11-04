<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AddTaskRequest extends FormRequest
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
            'task' => 'required|min:2|max:2100',
            'date' => 'required|date|max:20',
            'type' => 'required|integer|min:0|max:3',
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
            'task.min:2' => 'Минимальная длина задачи - 2 символа',
            'task.max:2100' => 'Максимальная длина задачи - 2100 символов',

            'type.required' => 'Необходимо выбрать тип задачи',
            'type.integer' => 'Тип задачи должен быть целым числом',
            'type.min:0' => 'Тип задачи начинает от 0',
            'type.max:3' => 'Максимальное значение для типа задачи - 3',

            'date.required' => 'Двта создания задачи должна быть сформирована',
            'date.date' => 'Дата задачи должна быть датой',
            'date.max:20' => 'Максимальное длина даты 20 символов',
        ];
        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(),'status' => true], 422));
    }
}
