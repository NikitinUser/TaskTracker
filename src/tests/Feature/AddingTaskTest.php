<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestsHelper;
use App\Models\User;
use App\Models\TasksMain;

class AddingTaskTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testAddTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => "task_text",
            'date' => "10-06-2021 14:00:00",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'date' => "10-06-2021 14:00:00",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskInvalidMinLengthTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => $this->generateStringLessMin(),
            'date' => "10-06-2021 14:00:00",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskInvalidMaxLengthTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => $this->generateStringMoreMax(),
            'date' => "10-06-2021 14:00:00",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutDate()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => "text",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithInvalidDate()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => "text",
            'date' => "not date",
            'priority' => 0,
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutPriority()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => "text",
            'date' => "10-06-2021 14:00:00",
            'type' => 0
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testAddTaskWithoutType()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $request = [
            'task' => "text",
            'priority' => 0,
            'date' => "10-06-2021 14:00:00",
        ];

        $response = $this->actingAs($user)
            ->post('/addTask', $request);
 
        $response->assertStatus(422);
    }
}
