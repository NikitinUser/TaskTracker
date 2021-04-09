<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class NewTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function validTask($data)
    {
        if (empty($data)) {
            Log::info("[".__FUNCTION__."]: empty data");
            return false;
        }

        if ( !isset($data['task']) ) {
            Log::info("[".__FUNCTION__."]: data[task] !isset");
            return false;
        }

        if (empty(trim($data['task']))) {
            Log::info("[".__FUNCTION__."]: data[task] empty");
            return false;
        }

        if (empty(preg_replace('/[^A-Za-z А-Яа-я 0-9]/ui', "", $data['task']))) {
            Log::info("[".__FUNCTION__."]: data[task] invalid data");
            return false;
        }

        return true;
    }

    public function validTaskDate($data)
    {

        if (!isset($data['date'])) {
            Log::info("[".__FUNCTION__."]: data[date] !isset");
            return false;
        }

        $dt_task = new \DateTime($data['date']);

        if (!$dt_task) {
            Log::info("[".__FUNCTION__."]: invalid date");
            return false;
        }

        $dt_task = $dt_task->format('Y-m-d H:i:s');

        if (!$dt_task) {
            Log::info("[".__FUNCTION__."]: invalid date");
            return false;
        }

        return $dt_task;
    }

    public function validTaskID($data)
    {

        if (!isset($data['id'])) {
            Log::info("[".__FUNCTION__."]: data[id] !isset");
            return false;
        }

        $data['id'] = preg_replace('/[^0-9]/', "", (explode("_", $data['id']))[1] );

        return $data['id'];
    }

    public function validTaskPriority($data)
    {

        if (!isset($data['priorityTask'])) {
            Log::info("[".__FUNCTION__."]: data[priorityTask] !isset");
            return false;
        }

        $data['priorityTask'] = preg_replace('/[^0-9]/', "", $data['priorityTask'] );

        return $data['priorityTask'];
    }
}
