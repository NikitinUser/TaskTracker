<?php

namespace App\Observers;

use App\Models\TasksMain;
use App\Services\TaskStatisticService;
use App\Services\TaskService;

class TasksMainObserver
{
    /**
     * Handle the TasksMain "creating" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function creating(TasksMain $tasksMain)
    {
        $taskService = new TaskService();
        $allowedAdd = $taskService->checkAllowedAdd($tasksMain->type);

        if (!$allowedAdd) {
            return false;
        }
    }

    /**
     * Handle the TasksMain "updated" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function updated(TasksMain $tasksMain)
    {
        $statisticService = new TaskStatisticService();

        $statisticService->commitDoneTaskByUserid($tasksMain);   
    }
}
