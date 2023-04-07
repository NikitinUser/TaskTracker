<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestsHelper;
use App\Models\User;
use App\Models\TasksMain;

class ChangeTaskTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testChangeTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => "task_text",
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
 
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testChangeTaskWithoutTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testChangeTaskInvalidMinLengthTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => $this->generateStringLessMin(),
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testChangeTaskInvalidMaxLengthTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => $this->generateStringMoreMax(),
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testChangeTaskWithoutId()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'task' => "text",
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->put('/tasks', $request);
 
        $response->assertStatus(422);
    }
}
