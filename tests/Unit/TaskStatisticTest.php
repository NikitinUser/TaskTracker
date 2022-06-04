<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TaskStatistic;

class TaskStatisticTest extends TestCase
{
    /**
     * @test
     */
    public function testGetStatisticByExistUserid()
    {
        $statistic = new TaskStatistic();
        $userId = 1;
        $res = $statistic->getStatisticByUserid($userId);
        
        $this->assertInstanceOf(TaskStatistic::class, $res);
    }

    /**
     * @test
     */
    public function testGetStatisticByExistUseridIssetCount()
    {
        $statistic = new TaskStatistic();
        $userId = 1;
        $res = $statistic->getStatisticByUserid($userId);

        $this->assertTrue(isset($res->doneTasks));
    }

    /**
     * @test
     */
    public function testGetStatisticByNotExistUserid()
    {
        $statistic = new TaskStatistic();
        $userId = 0;
        $res = $statistic->getStatisticByUserid($userId);

        $this->assertNull($res);
    }

    /**
     * @test
     */
    public function testCommitDoneTaskByExistUserid()
    {
        $statistic = new TaskStatistic();
        $userId = 1;
        $res = $statistic->incrementDoneTasks($userId);

        $this->assertTrue($res);
    }

    /**
     * @test
     */
    public function testCommitDoneTaskByNotExistUserid()
    {
        $statistic = new TaskStatistic();
        $userId = 0;
        $res = $statistic->incrementDoneTasks($userId);

        $this->assertFalse($res);
    }

    /**
     * @test
     */
    public function testCreateStatisticWithAllFields()
    {
        $statistic = new TaskStatistic();

        $statistic->userid = 1;
        $statistic->doneTasks = 0;

        $res = $statistic->save();

        $this->assertTrue($res);
    }
}
