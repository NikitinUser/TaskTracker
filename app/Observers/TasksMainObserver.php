<?php

namespace App\Observers;

use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;
use App\Models\TaskStatistic;

use Illuminate\Support\Facades\Redis;

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

        if ($countTasks >= $tasksMain::MAX_COUNT_TASKS_INTYPE) {

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

    /**
     * Handle the TasksMain "deleting" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function deleting(TasksMain $tasksMain)
    {
        $key = "task_" . $tasksMain->id . "_" . $tasksMain->userid;

        Redis::set($key, json_encode($tasksMain), 'EX', 60);
    }
}
