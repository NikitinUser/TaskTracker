<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\TasksMain;

use App\Repositories\TaskRepository;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\SwapTheTypeOfTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\RewriteTaskRequest;
use App\Http\Requests\RecoverTaskRequest;

use Illuminate\Support\Facades\Log;

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

    public function getUserTasks(GetTasksRequest $request, TaskRepository $taskRepository)
    {
        $type = intval($request->input('type'));

        $tasks = $taskRepository->getUserTasks($type);

        $tasks = json_encode($tasks);
        
        return $tasks;
    }
    
    public function addtask(AddTaskRequest $request, TasksMain $taskMain)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $addedTaskData = $taskMain->addNewTask($taskDataInput);

        $addedTaskData = json_encode($addedTaskData);

        return $addedTaskData;
    }

    public function rewriteTask(RewriteTaskRequest $request, TasksMain $taskMain)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $statusRewrite = $taskMain->rewriteTask($taskDataInput);

        return $statusRewrite;
    }
    
    public function swapTheTypeOfTask(SwapTheTypeOfTaskRequest $request, TasksMain $taskMain)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $statusSwapType = $taskMain->swapTheTypeOfTask($taskDataInput);
        
        return $statusSwapType;
    }

    public function deleteTask(DeleteTaskRequest $request, TasksMain $taskMain)
    {
        $taskID = intval($request->input('id') ?? 0);

        Log::info("[".__FUNCTION__."]: id task = " . $taskID);

        $statusDelete = $taskMain->removeTask($taskID);
        
        return $statusDelete;
    }

    public function recoverTask(RecoverTaskRequest $request, TasksMain $taskMain)
    {
        $taskID = intval($request->input('id') ?? 0);

        Log::info("[".__FUNCTION__."]: id task = " . $taskID);

        $recoveredTask = $taskMain->recoverTask($taskID);
        $recoveredTask = json_encode($recoveredTask);
        
        return $recoveredTask;
    }
}
