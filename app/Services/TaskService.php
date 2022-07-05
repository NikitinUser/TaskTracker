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
    
    /**
     * getUserTasksByType
     *
     * @param  int $type
     * @return array
     */
    public function getUserTasksByType(int $type): array
    {
        $userid = (int)auth()->user()->id;
        $tasks = $this->taskMain->getTasksByUseridAndType($userid, $type);

        if (empty($tasks))
            return [];
        
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }

        return $tasks;
    }
    
    /**
     * getCountUserTasksByType
     *
     * @param  int $type
     * @return int
     */
    public function getCountUserTasksByType(int $type): int
    {
        $userid = (int)auth()->user()->id;
        return $this->taskMain->getCountTasksByUseridAndType($userid, $type);
    }
    
    /**
     * addNewTask
     *
     * @param  array $task
     * @return array
     */
    public function addNewTask(array $task): array
    {
        $task['userid'] = (int)auth()?->user()?->id;

        $task['task'] = trim($task['task']);
        $task['task'] = base64_encode($task['task']);

        $dateTask = new \DateTime($task['date']);
        $task['dt_task'] = $dateTask->format('Y-m-d H:i:s');
        unset($task['date']);

        $newTask = TasksMain::create($task);

        $task['date'] = $task['dt_task'];
        $task['id'] = $newTask->id;
        $task['task'] = base64_decode($newTask->task);
        
        return $task;
    }
    
    /**
     * rewriteTask
     *
     * @param  array $task
     * @return bool
     */
    public function rewriteTask(array $task): bool
    {
        $this->taskMain = $this->taskMain->getTaskById((int)$task['id']);

        $this->taskMain->task = base64_encode(trim($task['task']));
        $this->taskMain->priority = $task['priority'];
        $this->taskMain->theme = $task['theme'] ?? "";

        return $this->taskMain->update();
    }
    
    /**
     * swapTypeTask
     *
     * @param  array $task
     * @return bool
     */
    public function swapTypeTask(array $task): bool
    {
        $this->taskMain = $this->taskMain->getTaskById((int)$task['id']);

        $dt_task = new \DateTime($task['date']);
        $task['date'] = $dt_task->format('Y-m-d H:i:s');

        $this->taskMain->type = $task['type'];
        $this->taskMain->dt_task = $task['date'];

        return $this->taskMain->update();
    }
    
    /**
     * deleteTask
     *
     * @param  int $idTask
     * @return bool
     */
    public function deleteTask(int $idTask): bool
    {
        $this->taskMain = $this->taskMain->getTaskById($idTask);

        $this->saveTaskToRedis($this->taskMain);

        return $this->taskMain->delete();
    }
    
    /**
     * recoverTask
     *
     * @param  int $idTask
     * @return TasksMain|null
     */
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
    
    /**
     * checkAllowedAdd
     *
     * @param  int $type
     * @return bool
     */
    public function checkAllowedAdd(int $type): bool
    {
        $countTasks = $this->getCountUserTasksByType($type);

        return $countTasks < TasksMain::MAX_COUNT_TASKS_INTYPE;
    }
    
    /**
     * saveTaskToRedis
     *
     * @param  TasksMain $task
     * @return void
     */
    private function saveTaskToRedis(TasksMain $task): void
    {
        $key = "task_" . $task->id . "_" . $task->userid;
        Redis::set($key, json_encode($task), 'EX', 60);
    }
    
    /**
     * getTaskFromRedis
     *
     * @param  int $idTask
     * @return void
     */
    private function getTaskFromRedis(int $idTask)
    {
        $userid = (int)auth()->user()->id;

        $key = "task_" . $idTask . "_" . $userid;

        return Redis::get($key);
    }
        
    /**
     * getUniqumTasksThemes
     *
     * @return array of TasksMain
     */
    public function getUniqumTasksThemes()
    {
        return $this->taskMain->select("theme")
            ->distinct()
            ->get();
    }
}
