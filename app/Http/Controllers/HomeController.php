<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Artisan;

use App\Http\Requests\NewTaskRequest;

use Illuminate\Console\Scheduling\Schedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $TasksMain = new TasksMain();

        $tasks = $TasksMain->allTasksUser(0);

        return json_encode($tasks);
    }

    public function getDoneTasks()
    {
        $TasksMain = new TasksMain();

        $tasks = $TasksMain->allTasksUser(1);

        return json_encode($tasks);
    }
    
    public function addtask(Request $request)
    {
        $userid = intval(auth()->user()->id);

        $data = [];
        $post = $request->all();

        Log::info("[".__FUNCTION__."]: user = " . $userid . ", data = " . json_encode($post));
        
        $NewTaskRequest = new NewTaskRequest();

        if (!$NewTaskRequest->validTask($post)) {
            return false;
        }  
       
        $post['date'] = $NewTaskRequest->validTaskDate($post);
        if (!$post['date']) {
            return false;
        }       

        $TasksMain = new TasksMain();
        $TasksMain->setType(0);
        $TasksMain->setPriority(0);
        $data = $TasksMain->addNewTask($post);

        return json_encode($data);
    }
    

    public function taskToDone(Request $request)
    {
        $userid = intval(auth()->user()->id);

        $post = $request->all();

        Log::info("[".__FUNCTION__."]: user = " . $userid . ", post = " . json_encode($post));

        $NewTaskRequest = new NewTaskRequest();

        $post['id'] = $NewTaskRequest->validTaskID($post);
        if (!$post['date']) {
            return false;
        }  

        $post['date'] = $NewTaskRequest->validTaskDate($post);
        if (!$post['date']) {
            return false;
        } 

        $TasksMain = new TasksMain();
        $TasksMain->setType(1);
        $status = $TasksMain->swapTypeTask($post);
        
        return $status;
    }

    public function deleteTask(Request $request)
    {
        $userid = intval(auth()->user()->id);

        $post = $request->all();

        Log::info("[".__FUNCTION__."]: user = " . $userid . ", post = " . json_encode($post));

        $NewTaskRequest = new NewTaskRequest();

        $post['id'] = $NewTaskRequest->validTaskID($post);
        if (!$post['id']) {
            return false;
        } 

        $TasksMain = new TasksMain();
        $status = $TasksMain->removeTask($post);
        
        return $status;
    }
}
