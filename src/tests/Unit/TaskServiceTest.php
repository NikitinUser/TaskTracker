<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\TestsHelper;
use App\Services\TaskService;
use App\Models\TasksMain;

class TaskServiceTest extends TestCase
{
    use TestsHelper;

    private int $testUserId = 1;

    /**
     * @test
     */
    public function testAddNewTask()
    {
        $taskService = new TaskService();
        $this->authByUserId($this->testUserId);

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $task = $this->getTestEntityArray($this->testUserId, $type);
            $res = $taskService->addNewTask($task);
            $this->assertIsArray($res);
        }
    }

    /**
     * @test
     */
    public function testRewriteTask()
    {
        $taskService = new TaskService();
        $this->authByUserId($this->testUserId);

        $task = $this->getTestEntityArray($this->testUserId);
        $initialTask = $taskService->addNewTask($task);

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $task = $this->getTestEntityArray($this->testUserId, $type);
            $task["id"] = $initialTask["id"];
            $res = $taskService->rewriteTask($task);
            $this->assertTrue($res);
        }
    }

    /**
     * @test
     */
    public function testGetNewUserTasksByType()
    {
        $taskService = new TaskService();
        $this->authByNewUser();

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $res = $taskService->getUserTasksByType($type);
            $this->assertTrue(is_array($res));
        }
    }

    /**
     * @test
     */
    public function testGetCountNewUserTasksByType()
    {
        $taskService = new TaskService();
        $this->authByNewUser();

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $res = $taskService->getCountUserTasksByType($type);
            $this->assertIsInt($res);
        }
    }

    /**
     * @test
     */
    public function testGetExistUserTasksByType()
    {
        $taskService = new TaskService();
        $this->authByUserId($this->testUserId);

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $res = $taskService->getUserTasksByType($type);
            $this->assertTrue(is_array($res));
        }
    }

    /**
     * @test
     */
    public function testGetCountExistUserTasksByType()
    {
        $taskService = new TaskService();
        $this->authByUserId($this->testUserId);

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $res = $taskService->getCountUserTasksByType($type);
            $this->assertIsInt($res);
        }
    }

    /**
     * @test
     */
    public function testDeleteTask()
    {
        $taskService = new TaskService();
        $this->authByUserId($this->testUserId);

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $task = $this->getTestEntityArray($this->testUserId, $type);
            $task = $taskService->addNewTask($task);
            $res = $taskService->deleteTask($task['id']);
            $this->assertTrue($res);
        }
    }
}
