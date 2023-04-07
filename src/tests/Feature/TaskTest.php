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

        $response = $this->actingAs($user)
                         ->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testHomePageWithAuthDone()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();
        
        $response = $this->actingAs($user)
                         ->get('/done');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testHomePageWithAuthArchive()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();
        
        $response = $this->actingAs($user)
                         ->get('/archive');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testHomePageWithAuthBookmarks()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();
        
        $response = $this->actingAs($user)
                         ->get('/bookmarks');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testGetTasksWithAuth()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();
        
        $response = $this->actingAs($user)
                         ->get('/tasks?type=' . TasksMain::TYPE_ACTIVE_TASK);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testDeleteTask()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $task = TasksMain::first();

        $request = [
            'id' => $task->id
        ];

        $response = $this->actingAs($user)
            ->delete('/tasks', $request);
 
        $response->assertStatus(200);
    }
}
