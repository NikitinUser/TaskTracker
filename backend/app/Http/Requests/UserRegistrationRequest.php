<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRegistrationRequest extends FormRequest
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
            'name' => 'required|min:8|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8|max:50',
        ];
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'Введите свое имя',
            'name.min:8' => 'Минимальная длина имени - 8 символа',
            'name.max:50' => 'Максимальная длина имени - 50 символов',

            'email.required' => 'Введите свою электронную почту',
            'email.email' => 'Введите свою электронную почту',

            'password.required' => 'Введите пароль',
            'password.min:8' => 'Минимальная длина пароля - 8 символа',
            'password.max:50' => 'Максимальная длина пароля - 50 символов',
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
