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
        return view('home');	
    }

    public function tasks_ajax(Request $request){
        header('Content-Type: application/json');
        $userid0 = auth()->user()->id;
        $userid = intval($userid0);

        $data = 'error';
        $post = json_decode(json_encode($request->all()), true);
        if (!empty($post)) {
            if (isset($post['action'])) {

                if ($post['action'] == 'get-storage') {
                    $tasks = TasksMain::select('task')->where('userid', $userid)->get();
                    //file_put_contents("log", json_encode($tasks));
                    $data = $tasks; //file_get_contents('storage.storage');
                }

                if ($post['action'] == 'set-storage') {

                    if (isset($post['data-storage'])) {
                        $data_storage = json_decode($post['data-storage'], true);
                        $data_storage = strval($data_storage['task']);
                        $data_storage = htmlspecialchars($data_storage);
                        $data_storage = trim($data_storage);

                        if (strlen($data_storage) > 300) {
                            $data_storage = mb_substr($data_storage, 0, 300);
                        }
                        $data_storage = trim($data_storage);
                        $data_todb = [];
                        if (!empty($data_storage)) {
                            $data_todb['task'] = $data_storage;
                            $data_todb['userid'] = $userid;

                            $taskmain = new TasksMain();
                            $taskmain->add($data_todb);
                            $data = 'success';
                        }
                    }
                }

            }
        }
        return $data;
    }
}
