<?php

namespace App\Observers;

use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;
use App\Models\TaskStatistic;

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
        $countTasks = $tasksMain->getCountTasks($tasksMain->type);

        if ($countTasks >= $tasksMain::MAX_COUNT_TASK_INTYPE) {

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
        if ($tasksMain->isDirty('type') && $tasksMain->type == $tasksMain::TYPE_DONE_TASK) {
            $TaskStatistic = new TaskStatistic();
            $TaskStatistic->commitDoneTask();
            unset($TaskStatistic);
        }   
    }
}
