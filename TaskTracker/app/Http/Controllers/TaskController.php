<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\SwapTheTypeOfTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\RewriteTaskRequest;
use App\Http\Requests\RecoverTaskRequest;

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

    public function getUserTasks(GetTasksRequest $request)
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

    public function rewriteTask(RewriteTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $res = $this->taskService->rewriteTask($taskDataInput);

        return json_encode($res);
    }
    
    public function swapTheTypeOfTask(SwapTheTypeOfTaskRequest $request)
    {
        $taskDataInput = $request->all();

        $statusSwapType = $this->taskService->swapTypeTask($taskDataInput);

        return $statusSwapType;
    }

    public function deleteTask(DeleteTaskRequest $request)
    {
        $taskId = (int)($request->input('id') ?? 0);

        $statusDelete = $this->taskService->deleteTask($taskId);

        return $statusDelete;
    }

    public function recoverTask(RecoverTaskRequest $request)
    {
        $taskId = (int)($request->input('id') ?? 0);

        $recoveredTask = $this->taskService->recoverTask($taskId);
        $recoveredTask = json_encode($recoveredTask);

        return $recoveredTask;
    }

    public function getTasksThemes()
    {
        $themes = $this->taskService->getUniqumTasksThemes();

        return json_encode($themes);
    }
}
