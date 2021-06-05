<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

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
            'task'          => 'required|min:3',
            'date'          => 'required', 
            'priorityTask'  => 'required|integer|min:0|max:3',
            'type'          => 'required|integer|min:0|max:3',
        ];
    }
}
