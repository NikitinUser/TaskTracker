<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\TestsHelper;
use App\Services\TaskStatisticService;
use App\Models\TasksMain;
use App\Models\TaskStatistic;

class TaskStatisticServiceTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testGetCountTasks()
    {
        $statisticService = new TaskStatisticService();
        $userId = $this->createNewUserGetId();
        
        $this->authByUserId($userId);

        $res = $statisticService->getCountTasks($userId);
        
        $this->assertIsArray($res);
    }

    /**
     * @test
     */
    public function testCommitDoneTaskByExistUserid()
    {
        $statisticService = new TaskStatisticService();
        $userId = $this->createNewUserGetId();

        $this->authByUserId($userId);

        $task = TasksMain::create(
            [
                "task" => "3232",
                "userid" => $userId,
                "dt_task" => "2022-06-26 03:14:23",
                "type" => 0,
                "priority" => 0,
            ]
        );

        $task->type = TasksMain::TYPE_DONE_TASK;

        $res = true;
        try {
            $statisticService->commitDoneTaskByUserid($task);
        } catch (\Exception $e) {
            $res = false;
        }

        $this->assertTrue($res);
    }

    /**
     * @test
     */
    public function testCommitDoneTaskByNotExistUserid()
    {
        $statisticService = new TaskStatisticService();
        $userId = 0;

        $this->authByUserId($userId);

        $task = new TasksMain();

        $task->type = TasksMain::TYPE_DONE_TASK;

        $res = true;
        try {
            $statisticService->commitDoneTaskByUserid($task);
        } catch (\Exception $e) {
            $res = false;
        }

        $this->assertFalse($res);
    }

    /**
     * @test
     */
    public function testAddStatisticToUser()
    {
        $statisticService = new TaskStatisticService();

        $userId = $this->createNewUserGetId();

        $res = true;
        try {
            $statisticService->addStatisticToUser($userId);
        } catch (\Exception $e) {
            $res = false;
        }
        
        $this->assertTrue($res);
    }
}
