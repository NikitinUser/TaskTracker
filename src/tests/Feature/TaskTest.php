<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestsHelper;
use App\Models\User;
use App\Models\TasksMain;

class TaskTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testHomePageWithoutAuth()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function testHomePageWithAuth()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testGetTasksWithAuth()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        foreach (TasksMain::TYPES_ARRAY_ID as $type) {
            $response = $this->actingAs($user)
                ->get('/tasks?type=' . $type);
            $response->assertStatus(200);
        }
    }

    /**
     * @test
     */
    public function testAddTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = $this->getTestEntityArray($userId);

        $response = $this->actingAs($user)
            ->post('/tasks', $request);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = $this->getTestEntityArray($userId);
        unset($request["task"]);

        $response = $this->actingAs($user)
            ->post('/tasks', $request);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutDate()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = $this->getTestEntityArray($userId);
        unset($request["date"]);

        $response = $this->actingAs($user)
            ->post('/tasks', $request);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutType()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = $this->getTestEntityArray($userId);
        unset($request["type"]);

        $response = $this->actingAs($user)
            ->post('/tasks', $request);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testUpdateTask()
    {
        $task = TasksMain::first();
        $user = User::where("id", $task->userid)->first();

        $request = $this->getTestEntityArray($task->userid);
        $request["id"] = $task->id;

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testUpdateTaskWithoutTask()
    {
        $task = TasksMain::first();
        $user = User::where("id", $task->userid)->first();

        $request = $this->getTestEntityArray($task->userid);
        $request["id"] = $task->id;
        unset($request["task"]);

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testUpdateTaskWithoutId()
    {
        $task = TasksMain::first();
        $user = User::where("id", $task->userid)->first();

        $request = $this->getTestEntityArray($task->userid);
        $request["id"] = $task->id;
        unset($request["id"]);

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testDeleteTask()
    {
        $task = TasksMain::first();
        $user = User::where("id", $task->userid)->first();

        $request = ['id' => $task->id];

        $response = $this->actingAs($user)
            ->delete('/tasks', $request);
        $response->assertStatus(200);
    }
}
