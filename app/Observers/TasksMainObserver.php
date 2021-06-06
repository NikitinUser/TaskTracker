<?php

namespace App\Observers;

use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;
use App\Models\TaskStatistic;

class TasksMainObserver
{
    /**
     * Handle the TasksMain "created" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function created(TasksMain $tasksMain)
    {
        //
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
     * Handle the TasksMain "deleted" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function deleted(TasksMain $tasksMain)
    {
        //
    }

    /**
     * Handle the TasksMain "restored" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function restored(TasksMain $tasksMain)
    {
        //
    }

    /**
     * Handle the TasksMain "force deleted" event.
     *
     * @param  \App\Models\TasksMain  $tasksMain
     * @return void
     */
    public function forceDeleted(TasksMain $tasksMain)
    {
        //
    }
}
