<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;

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

        return view('home', compact('tasks') );	
    }

    public function tasks_ajax(Request $request){
        header('Content-Type: application/json');
        $userid0 = auth()->user()->id;
        $userid = intval($userid0);

        $data = 'error';
        $post = json_decode(json_encode($request->all()), true);

        //file_put_contents("log", "1");
        if (!empty($post)) {
            if (isset($post['action'])) {

                if ($post['action'] == 'get-storage') {
                    $tasks = TasksMain::select('task', 'id', 'dt_send')->where('userid', $userid)->get();
                    
                    $data = $tasks; 
                }

                if ($post['action'] == 'set-storage') {
                    if (isset($post['task'])) {
                        $data_storage = strval(json_decode($post['task']) );
                        $data_storage = trim($data_storage);
                        $data_storage = htmlspecialchars($data_storage);
                        

                        if (strlen($data_storage) > 300) {
                            $data_storage = mb_substr($data_storage, 0, 300);
                        }
                        $data_storage = trim($data_storage);
                        $data_todb = [];
                        if (!empty($data_storage)) {
                            $date = new \DateTime(null, new \DateTimeZone('Europe/Moscow'));
                            $date = $date->format('Y-m-d H:i');
                            $data_todb['task'] = $data_storage;
                            $data_todb['userid'] = $userid;
                            $data_todb['dt_send'] = $date;   
                            $taskmain = new TasksMain();
                            $data_todb['id'] = $taskmain->add($data_todb);
                            unset($data_todb['userid']);
                            $data = $data_todb;
                        }
                    }
                }

            }
        }
        return $data;
    }
    
    public function addtask(Request $request){
        header('Content-Type: application/json');
        $userid = intval(auth()->user()->id);

        $data = 'error';
        $post = json_decode(json_encode($request->all()), true);

        
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
                    $date = new \DateTime(null, new \DateTimeZone('Europe/Moscow'));
                    $date = $date->format('Y-m-d H:i');
                    $data_todb['task'] = $data_storage;
                    $data_todb['userid'] = $userid;
                    $data_todb['dt_send'] = $date;   
                    $taskmain = new TasksMain();
                    $data_todb['id'] = $taskmain->add($data_todb);
                    unset($data_todb['userid']);
                    $data = "<li class='list-group-item'>
                                <div class='row'>
                                    <div class=' col-md-1 col-sm-1'>
                                        <input type='checkbox' class='pull-left'>
                                        <label><em style='font-size: x-small'>" . $data_todb['dt_send'] . "</em></label>
                                    </div> 
                                    <div class='col-md-10 col-sm-10 text-center'>
                                        " . $data_todb['task'] . "
                                    </div> 
                                    <div class='col-md-1 col-sm-1'>
                                        <button class='pull-right btn btn-outline-danger btn-sm ' id='idtask_" . $data_todb['id'] . "' onclick='toTrash(this)'>
                                            <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                </div>
                            </li>";
                }
            }
        }
        return $data;
    }
    

    public function totrash(Request $request){
        header('Content-Type: application/json');
        $userid = intval(auth()->user()->id);
        $status = 0;
        $post = json_decode(json_encode($request->all()), true);
        if (!empty($post)) {
            if (isset($post['id'])) {

                $id = intval(explode("_", $post['id'])[1]);
                $affected = TasksMain::where('id', '=', $id)->delete();
                $status = 1;
            }
        }
        return $status;
    }
}
