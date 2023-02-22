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
            'theme' => "Testing",
            'priority' => 1,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
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
            'theme' => "Testing",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
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
            'theme' => "Testing",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
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
            'theme' => "Testing",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testChangeTaskWithoutTheme()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => "text",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testChangeTaskWithInvalidTheme()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => "text",
            'theme' => "!@#$#%^%&(**)_+=?><<M'`~",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function testChangeTaskWithoutPriority()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id,
            'task' => "text",
            'theme' => "Testing",
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
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
            'theme' => "Testing",
            'priority' => 0,
        ];

        $response = $this->actingAs($user)
            ->post('/changeTask', $request);
 
        $response->assertStatus(422);
    }
}
