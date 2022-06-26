<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestsHelper;
use App\Models\User;

class TaskStatisticTest extends TestCase
{
    use TestsHelper;

    /**
     * @test
     */
    public function testStatisticPageWithAuth()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $response = $this->actingAs($user)
                         ->get('/statistic');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function testGetCountTasksWithAuth()
    {
        $userId = $this->createNewUserGetId();
        $user = User::where("id", $userId)->first();

        $response = $this->actingAs($user)
                         ->get('/getCountTasks');

        $response->assertStatus(200);
    }
}
