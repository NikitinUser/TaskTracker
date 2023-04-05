<?php

namespace App\Services;

use App\Models\TasksMain;

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

        $dtTask = new \DateTime($task['date']);
        $task['date'] = $dtTask->format('Y-m-d H:i:s');

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

        return $this->taskMain->delete();
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

}
