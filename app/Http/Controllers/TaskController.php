<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\MoveTaskRequest;
use App\Http\Requests\DeleteTaskRequest;

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

    public function getMainTasks()
    {
        $tasks = $this->TasksMain->allTasksUser(TasksMain::TYPE_ACTIVE_TASK);

        $tasks = json_encode($tasks);

        return $tasks;
    }

    public function getDoneTasks()
    {
        $tasks = $this->TasksMain->allTasksUser(TasksMain::TYPE_DONE_TASK);

        $tasks = json_encode($tasks);

        return $tasks;
    }
    
    public function addtask(AddTaskRequest $request)
    {
        $post = $request->all();

        Log::info("[".__FUNCTION__."]: data = " . json_encode($post));

        $data = $this->TasksMain->addNewTask($post, TasksMain::TYPE_ACTIVE_TASK);

        $data = json_encode($data);

        return $data;
    }
    

    public function taskToDone(MoveTaskRequest $request)
    {
        $post = $request->all();

        Log::info("[".__FUNCTION__."]: post = " . json_encode($post));

        $status = $this->TasksMain->swapTypeTask($post, TasksMain::TYPE_DONE_TASK);
        
        return $status;
    }

    public function deleteTask(DeleteTaskRequest $request)
    {
        $post = $request->all();

        Log::info("[".__FUNCTION__."]: post = " . json_encode($post));

        $status = $this->TasksMain->removeTask($post);
        
        return $status;
    }
}
