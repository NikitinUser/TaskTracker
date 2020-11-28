<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use App\Models\User;
use Artisan;

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

        $chat_id = User::select('chat_id')->where('id', "=", $userid)->get()->toArray();
        $chat_id = strval($chat_id[0]['chat_id']);

        $tasks = TasksMain::select('task', 'id', 'dt_send')->where([
                                                                    ['userid', "=", $userid], 
                                                                    ['trash', "<>", 1]
                                                                ])->get()->toArray();
        //dd($tasks);

        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }
        return view('home', compact('tasks', 'chat_id') );	
    }

    public function trash()
    {
        $userid = intval(auth()->user()->id);
        $tasks = TasksMain::select('task', 'id', 'dt_send')->where([
                                                                    ['userid', "=", $userid], 
                                                                    ['trash', "=", 1]
                                                                ])->get()->toArray();
        //dd($tasks);
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }
        
        return view('home', compact('tasks') ); 
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
                    $data_storage = base64_encode($data_storage);
                    $date = new \DateTime(null, new \DateTimeZone('Europe/Moscow'));
                    $date = $date->format('Y-m-d H:i');
                    $data_todb['task'] = $data_storage;
                    $data_todb['userid'] = $userid;
                    $data_todb['dt_send'] = $date;   
                    $taskmain = new TasksMain();
                    $data_todb['id'] = $taskmain->add($data_todb);
                    unset($data_todb['userid']);

                    $buf_str = '<button class="pull-right btn btn-outline-danger btn-sm " id="idtask_'.$data_todb['id'].'" onclick="toTrash(this)">
                                                <i class="fa fa-trash"></i>
                                            </button>';
                                            
                    $chat_id = User::select('chat_id')->where('id', "=", $userid)->get()->toArray();
                    $chat_id = strval($chat_id[0]['chat_id']);
                    if (!empty($chat_id)) {
                        $buf_str .= '<button class="pull-right btn btn-outline-secondary btn-sm " id="sendidtask_'.$data_todb['id'].'" onclick="ConfirmSendTelegramTask(this)">
                                                    <i class="fa fa-telegram" aria-hidden="true"></i>
                                                </button>';
                    }
                    
                    $data = '<li class="list-group-item">
                                <div class="row">
                                    <div class=" col-md-1 col-sm-1">
                                        <label><em style="font-size: x-small">'. $data_todb['dt_send'] . '"(мск)" </em></label>
                                    </div> 
                                    <div class="col-md-10 col-sm-10 text-center">
                                        '. base64_decode($data_todb['task']) .'
                                    </div> 
                                    <div class="col-md-1 col-sm-1">'
                                     .   $buf_str .
                                    '</div>
                                </div>
                            </li>';
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
                $affected = TasksMain::where([
                                                ['userid', "=", $userid], 
                                                ['id', '=', $id]
                                            ])->update(['trash' => 1]);
                $status = 1;
            }
        }
        return $status;
    }

    public function deleteTask(Request $request){
        header('Content-Type: application/json');
        $userid = intval(auth()->user()->id);
        $status = 0;
        $post = json_decode(json_encode($request->all()), true);
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
        return $status;
    }

    public function send(Request $request){
        $userid = intval(auth()->user()->id);

        $post = json_decode(json_encode($request->all()), true);
        $id_task = 0;
        $minuts = 0;
        if (!empty($post)) {
            if (isset($post['id'])) {
                $id_task = intval(explode("_", $post['id'])[1]);
            }
            if (isset($post['minuts'])) {
                $minuts = intval($post['minuts']);
            }
        }
        if ( !empty($id_task) ) {
            $chat_id = User::select('chat_id')->where('id', "=", $userid)->get()->toArray();
            $chat_id = strval($chat_id[0]['chat_id']);
            if (!empty($chat_id)) {
                $record = TasksMain::select('sending_status')->where([
                                                                        ['userid', "=", $userid], 
                                                                        ['id', "=", $id_task]
                                                                    ])->get()->toArray();
                $status = $record[0]['sending_status'];
                if (intval($status) === 0) {
                    $arr_totg = [
                                    'userid'  => $userid,
                                    'id_task' => $id_task,
                                    'minuts'  => $minuts,
                                    'chat_id' => $chat_id
                                ];
                    $arr_totg = json_encode($arr_totg);
                    $exitCode = Artisan::call('command:SendTaskCommand', ['inputarr' => $arr_totg] );
                    return 1;
                } else {
                    return -1;
                }
                
            }
            
        }
        return 0;
    }
}
