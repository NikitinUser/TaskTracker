<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\TestsHelper;
use App\Services\TaskService;
use App\Models\TasksMain;

class TaskServiceTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testGetUserTasksByType()
    {
        $taskService = new TaskService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $res = $taskService->getUserTasksByType(TasksMain::TYPE_ACTIVE_TASK);
        
        $this->assertTrue(is_array($res) || is_null($res));
    }

    /**
     * @test
     */
    public function testGetCountUserTasksByType()
    {
        $taskService = new TaskService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $res = $taskService->getCountUserTasksByType(TasksMain::TYPE_ACTIVE_TASK);
        
        $this->assertIsInt($res);
    }

    /**
     * @test
     */
    public function testAddNewTask()
    {
        $taskService = new TaskService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $task = [
            "task" => "3232",
            "userid" => $userId,
            "date" => "2022-06-26 03:14:23",
            "type" => 0
        ];

        $res = $taskService->addNewTask($task);
        
        $this->assertIsArray($res);
    }

    /**
     * @test
     */
    public function testRewriteTask()
    {
        $taskService = new TaskService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $task = [
            "task" => "3232",
            "userid" => $userId,
            "date" => "2022-06-26 03:14:23",
            "type" => 0
        ];

        $task = $taskService->addNewTask($task);
        $task["date"] = "2022-06-26 03:14:23";

        $res = $taskService->rewriteTask($task);
        
        $this->assertTrue($res);
    }

    /**
     * @test
     */
    public function testDeleteTask()
    {
        $taskService = new TaskService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $task = [
            "task" => "3232",
            "userid" => $userId,
            "date" => "2022-06-26 03:14:23",
            "type" => 0
        ];

        $task = $taskService->addNewTask($task);

        $res = $taskService->deleteTask($task['id']);
        
        $this->assertTrue($res);
    }
}
