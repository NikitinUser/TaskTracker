<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\SwapTheTypeOfTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->taskService = new TaskService();
    }

    public function index()
    {
        return view('home'); 
    }

    public function getUserTasks(Request $request)
    {
        $type = (int)$request->input('type');

        $tasks = $this->taskService->getUserTasksByType($type);

        $tasks = json_encode($tasks);

        return $tasks;
    }
    
    public function addtask(AddTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $addedTaskData = $this->taskService->addNewTask($taskDataInput);

        $addedTaskData = json_encode($addedTaskData);

        return $addedTaskData;
    }

    public function updateTask(UpdateTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $res = $this->taskService->updateTask($taskDataInput);

        return json_encode($res);
    }
    
    public function deleteTask(DeleteTaskRequest $request)
    {
        $taskId = (int)($request->input('id') ?? 0);

        $statusDelete = $this->taskService->deleteTask($taskId);

        return $statusDelete;
    }
}
