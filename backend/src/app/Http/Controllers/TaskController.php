<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function getUserTasks(Request $request)
    {
    }
    
    public function addtask(AddTaskRequest $request)
    {
    }

    public function updateTask(UpdateTaskRequest $request)
    {
    }
    
    public function deleteTask(DeleteTaskRequest $request)
    {
    }
}
