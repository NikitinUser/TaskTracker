<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Artisan;

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
        $userid = intval(auth()->user()->id);
        $tasks = TasksMain::select('task', 'id', 'dt_send')->where([
                                                                    ['userid', "=", $userid], 
                                                                    ['trash', "<>", 1]
                                                                ])->get()->toArray();
        //dd($tasks);

        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }
        return view('home', compact('tasks') ); 
    }

    public function trash()
    {
        $userid = intval(auth()->user()->id);
        $tasks = TasksMain::select('task', 'id', 'dt_send')->where([
                                                                    ['userid', "=", $userid], 
                                                                    ['trash', "=", 1]
                                                                ])->orderBy('dt_send', 'asc')->get()->toArray();
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }
        
        return view('home', compact('tasks') ); 
    }
    
    public function addtask(Request $request)
    {
        $userid = intval(auth()->user()->id);

        $data = [];
        $post = json_decode(json_encode($request->all()), true);
        Log::info("add task:: user = " . $userid . ", post = " . json_encode($post));

        if (!empty($post)) {
            if (isset($post['task'])) {
                $data_storage = strval($post['task'] );
                $data_storage = trim($data_storage);
                $data_storage = htmlspecialchars($data_storage);
                if (strlen($data_storage) > 300) {
                    $data_storage = mb_substr($data_storage, 0, 300);
                }
                $data_storage = trim($data_storage);
                
                $data_todb = [];
                if (!empty($data_storage)) {
                    Log::info("add task:: user = " . $userid . ", data_storage = " . json_encode($data_storage));
                    $data_storage = base64_encode($data_storage);
                    $date = new \DateTime($post['date']);
                    $date = $date->format('Y-m-d H:i:s');
                    $data_todb['task'] = $data_storage;
                    $data_todb['userid'] = $userid;
                    $data_todb['dt_send'] = $date;   
                    $taskmain = new TasksMain();
                    
                    $data['id'] = $taskmain->add($data_todb);
                    $data['date'] = $date;
                    $data = json_encode($data);
                }
            }
        }
        return $data;
    }
    

    public function totrash(Request $request)
    {
        $userid = intval(auth()->user()->id);
        $status = 0;
        $post = json_decode(json_encode($request->all()), true);
        Log::info("totrash:: user = " . $userid . ", post = " . json_encode($post));
        if (!empty($post)) {
            $date = new \DateTime($post['date']);
            $date = $date->format('Y-m-d H:i:s');
            if (isset($post['id'])) {

                $id = intval(explode("_", $post['id'])[1]);
                $affected = TasksMain::where([
                                                ['userid', "=", $userid], 
                                                ['id', '=', $id],
                                            ])->update(['trash' => 1, 'dt_send' => $date ]);
                $status = 1;
            }
        }
        Log::info("totrash:: user = " . $userid . ", status = " . json_encode($status));
        return $status;
    }

    public function deleteTask(Request $request)
    {
        $userid = intval(auth()->user()->id);
        $status = 0;
        $post = json_decode(json_encode($request->all()), true);
        Log::info("deleteTask:: user = " . $userid . ", post = " . json_encode($post));
        if (!empty($post)) {
            if (isset($post['id'])) {

                $id = intval(explode("_", $post['id'])[1]);
                $affected = TasksMain::where([
                                                ['userid', "=", $userid], 
                                                ['id', '=', $id]
                                            ])->delete();
                $status = 1;
            }
        }
        Log::info("deleteTask:: user = " . $userid . ", status = " . json_encode($status));
        return $status;
    }
}
