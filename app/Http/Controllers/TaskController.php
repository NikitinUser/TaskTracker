<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\SwapTheTypeOfTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\RewriteTaskRequest;
use App\Http\Requests\RecoverTaskRequest;

class TaskController extends Controller
{
    private $TasksMain;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->TasksMain = new TasksMain();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home'); 
    }

    public function getUserTasks(GetTasksRequest $request)
    {
        $type = intval($request->input('type'));

        $tasks = $this->TasksMain->getUserTasks($type);

        $tasks = json_encode($tasks);
        
        return $tasks;
    }
    
    public function addtask(AddTaskRequest $request)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $addedTaskData = $this->TasksMain->addNewTask($taskDataInput);

        $addedTaskData = json_encode($addedTaskData);

        return $addedTaskData;
    }

    public function rewriteTask(RewriteTaskRequest $request)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $statusRewrite = $this->TasksMain->rewriteTask($taskDataInput);

        return $statusRewrite;
    }
    
    public function swapTheTypeOfTask(SwapTheTypeOfTaskRequest $request)
    {
        $taskDataInput = $request->all();

        Log::info("[".__FUNCTION__."]: input data of task = " . json_encode($taskDataInput));

        $statusSwapType = $this->TasksMain->swapTheTypeOfTask($taskDataInput);
        
        return $statusSwapType;
    }

    public function deleteTask(DeleteTaskRequest $request)
    {
        $taskID = intval($request->input('id') ?? 0);

        Log::info("[".__FUNCTION__."]: id task = " . $taskID);

        $statusDelete = $this->TasksMain->removeTask($taskID);
        
        return $statusDelete;
    }

    public function recoverTask(RecoverTaskRequest $request)
    {
        $taskID = intval($request->input('id') ?? 0);

        Log::info("[".__FUNCTION__."]: id task = " . $taskID);

        $recoveredTask = $this->TasksMain->recoverTask($taskID);
        $recoveredTask = json_encode($recoveredTask);
        
        return $recoveredTask;
    }
}
