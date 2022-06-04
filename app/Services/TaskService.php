<?php

namespace App\Services;

use App\Models\TasksMain;
use Illuminate\Support\Facades\Redis;

class TaskService
{
    private TasksMain $taskMain;

    public function __construct()
    {
        $this->taskMain = new TasksMain();
    }

    public function getUserTasksByType(int $type): ?array
    {
        $userid = (int)auth()->user()->id;
        $tasks = $this->taskMain->getTasksByUseridAndType($userid, $type);

        if (empty($tasks))
            return null;
        
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }

        return $tasks;
    }

    public function getCountUserTasksByType(int $type)
    {
        $userid = (int)auth()->user()->id;
        return $this->taskMain->getCountTasksByUseridAndType($userid, $type);
    }

    public function addNewTask(array $task): array
    {
        $task['userid'] = (int)auth()?->user()?->id;

        $task['task'] = trim($task['task']);
        $task['task'] = base64_encode($task['task']);

        $dateTask = new \DateTime($task['date']);
        $task['dt_task'] = $dateTask->format('Y-m-d H:i:s');
        unset($task['date']);

        $newTask = TasksMain::create($task);

        $task['id'] = $newTask->id;
        
        return $task;
    }

    public function rewriteTask(array $task): bool
    {
        $this->taskMain = $this->taskMain->getTaskById((int)$task['id']);

        $this->taskMain->task = base64_encode(trim($task['task']));
        $this->taskMain->priority = $task['priorityTask'];

        return $this->taskMain->update();
    }

    public function swapTypeTask(array $task): bool
    {
        $this->taskMain = $this->taskMain->getTaskById((int)$task['id']);

        $dt_task = new \DateTime($task['date']);
        $task['date'] = $dt_task->format('Y-m-d H:i:s');

        $this->taskMain->type = $task['type'];
        $this->taskMain->dt_task = $task['date'];

        return $this->taskMain->update();
    }

    public function deleteTask(int $idTask): bool
    {
        $this->taskMain = $this->taskMain->getTaskById($idTask);

        $this->saveTaskToRedis($this->taskMain);

        return $this->taskMain->delete();
    }

    public function recoverTask(int $idTask): ?TasksMain
    {
        $task = $this->getTaskFromRedis($idTask);
        $task = json_decode($task, true);

        if (empty($task)) {
            return null;
        }

        $this->taskMain->forceFill($task);

        $this->taskMain->save();

        $this->taskMain->task = base64_decode($this->taskMain->task);

        return $this->taskMain;
    }

    public function checkAllowedAdd(int $type)
    {
        $countTasks = $this->getCountUserTasksByType($type);

        return $countTasks < TasksMain::MAX_COUNT_TASKS_INTYPE;
    }

    private function saveTaskToRedis(TasksMain $task): void
    {
        $key = "task_" . $task->id . "_" . $task->userid;
        Redis::set($key, json_encode($task), 'EX', 60);
    }

    private function getTaskFromRedis(int $idTask)
    {
        $userid = (int)auth()->user()->id;

        $key = "task_" . $idTask . "_" . $userid;

        return Redis::get($key);
    }
}