<?php

namespace App\Services;

use App\Repositories\TaskRepository;
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
        $tasksRepository = new TaskRepository();

        $userid = (int)auth()->user()->id;

        $countActive = $tasksRepository->getCountTasks($tasksRepository::TYPE_ACTIVE_TASK);
    	$countArchive = $tasksRepository->getCountTasks($tasksRepository::TYPE_ARCHIVE_TASK);
    	$countDone = $this->taskStatistic->getStatisticByUserid($userid);

    	$data = [
    			 'countActive'  => $countActive,
    			 'countDone' 	=> $countDone,
    			 'countArchive' => $countArchive
    	];

    	$data = json_encode($data);
    }

    public function commitDoneTaskByUserid(TasksMain $tasksMain)
    {
        if (
            $tasksMain->isDirty('type')
            && $tasksMain->type == $tasksMain::TYPE_DONE_TASK
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