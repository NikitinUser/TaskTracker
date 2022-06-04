<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Services\TaskService;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\SwapTheTypeOfTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\RewriteTaskRequest;
use App\Http\Requests\RecoverTaskRequest;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home'); 
    }

    public function getUserTasks(GetTasksRequest $request)
    {
        $type = (int)$request->input('type');

        $taskService = new TaskService();
        $tasks = $taskService->getUserTasksByType($type);

        $tasks = json_encode($tasks);
        
        return $tasks;
    }
    
    public function addtask(AddTaskRequest $request)
    {
        $taskDataInput = $request->all();
        
        $taskService = new TaskService();
        $addedTaskData = $taskService->addNewTask($taskDataInput);

        $addedTaskData = json_encode($addedTaskData);

        return $addedTaskData;
    }

    public function rewriteTask(RewriteTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $taskService = new TaskService();
        $res = $taskService->rewriteTask($taskDataInput);

        return json_encode($res);
    }
    
    public function swapTheTypeOfTask(SwapTheTypeOfTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $taskService = new TaskService();
        $statusSwapType = $taskService->swapTypeTask($taskDataInput);
        
        return $statusSwapType;
    }

    public function deleteTask(DeleteTaskRequest $request)
    {
        $taskID = (int)($request->input('id') ?? 0);

        $taskService = new TaskService();
        $statusDelete = $taskService->deleteTask($taskID);
        
        return $statusDelete;
    }

    public function recoverTask(RecoverTaskRequest $request)
    {
        $taskID = (int)($request->input('id') ?? 0);

        $taskService = new TaskService();

        $recoveredTask = $taskService->recoverTask($taskID);
        $recoveredTask = json_encode($recoveredTask);
        
        return $recoveredTask;
    }
}
