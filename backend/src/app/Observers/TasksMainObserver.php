<?php

namespace App\Observers;

use App\Models\TasksMain;
use App\Services\TaskService;

class TasksMainObserver
{
    /**
     * Handle the TasksMain "creating" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return mixed
     */
    public function creating(TasksMain $tasksMain)
    {
        $taskService = new TaskService();
        $allowedAdd = $taskService->checkAllowedAdd($tasksMain->type);

        if (!$allowedAdd) {
            return false;
        }
    }
}
