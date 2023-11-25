<?php

namespace App\Services;

use App\DTO\TaskDTO;
use App\DTO\TaskCollectionDTO;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Models\Task;
use App\Transformers\TaskModelTransformer;

class TaskService
{
    private TaskModelTransformer $taskModelTransformer;

    public function __construct()
    {
        $this->taskModelTransformer = new TaskModelTransformer();
    }

    /**
     * @param int $userId
     * 
     * @return TaskCollectionDTO
     */
    public function getAll(int $userId): TaskCollectionDTO
    {
        $dtoCollection = new TaskCollectionDTO();
        $tasks = Task::where('userid', $userId)->get();

        if (empty($tasks)) {
            return $dtoCollection;
        }

        for ($i = 0; $i < count($tasks); $i++) {
            $dtoCollection->tasks[] = $this->taskModelTransformer->transform($tasks[$i]);
        }

        return $dtoCollection;
    }

    /**
     * @param CreateTaskDTO $taskDto
     * 
     * @return TaskDTO
     */
    public function create(CreateTaskDTO $taskDto): TaskDTO
    {
        $id = Task::insertGetId((array)$taskDto);
        $task = Task::where('id', $id)->first();

        return $this->taskModelTransformer->transform($task);
    }

    /**
     * @param UpdateTaskDTO $taskDto
     * 
     * @return void
     */
    public function update(UpdateTaskDTO $taskDto): void
    {
        Task::where('id', $taskDto->id)
            ->update((array)$taskDto);
    }

    /**
     * @param int @userId
     * @param int $taskId
     * 
     * @return void
     */
    public function delete(int $userId, int $taskId): void
    {
        Task::where('id', $taskId)
            ->where('userid', $userId)
            ->delete();
    }
}
