<?php

namespace App\Services;

use App\Services\TaskService;
use App\Models\TaskStatistic;
use App\Models\TasksMain;

class TaskStatisticService
{
    private TaskStatistic $taskStatistic;

    public function __construct()
    {
        $this->taskStatistic = new TaskStatistic();
    }

    public function getCounTasks(): array
    {
        $tasksService = new TaskService();

        $userid = (int)auth()->user()->id;

        $countActive = $tasksService->getCountUserTasksByType(TasksMain::TYPE_ACTIVE_TASK);
    	$countArchive = $tasksService->getCountUserTasksByType(TasksMain::TYPE_ARCHIVE_TASK);
    	$statistic = $this->taskStatistic->getStatisticByUserid($userid);

    	return [
    			 'countActive'  => $countActive,
    			 'countDone' 	=> $statistic?->doneTasks,
    			 'countArchive' => $countArchive
    	];
    }

    public function commitDoneTaskByUserid(TasksMain $tasksMain)
    {
        if (
            $tasksMain->isDirty('type')
            && (int)$tasksMain->type == TasksMain::TYPE_DONE_TASK
        ) {
            $userid = (int)auth()->user()->id;

            $this->taskStatistic->incrementDoneTasks($userid);
        }
    }

    public function addStatisticToUser(int $userid): void
    {
        $this->taskStatistic->userid = $userid;
        $this->taskStatistic->doneTasks = 0;

        $this->taskStatistic->save();
    }
}
