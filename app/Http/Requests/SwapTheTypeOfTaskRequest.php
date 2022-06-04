<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SwapTheTypeOfTaskRequest extends FormRequest
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
            'id'    => 'required|integer',
            'date'  => 'required|date|max:20', 
            'type'  => 'required|integer|min:0|max:3',
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
            'date.required' => 'Двта создания задачи должна быть сформирована',
            'date.date' => 'Дата задачи должна быть датой',
            'date.max:20' => 'Максимальное длина даты 20 символов',

            'type.required' => 'Необходимо выбрать тип задачи',
            'type.integer' => 'Тип задачи должен быть целым числом',
            'type.min:0' => 'Тип задачи начинает от 0',
            'type.max:3' => 'Максимальное значение для типа задачи - 3',

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
