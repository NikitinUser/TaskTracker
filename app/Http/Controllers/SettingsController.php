<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TasksMain;
use App\Models\User;

class SettingsController extends Controller{
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
    public function settings()
    {
        $userid = intval(auth()->user()->id);

        return view('settings' );	
    }

    //	токен бота
    const TELEGRAM_TOKEN = '1445980108:AAFCAXQvtQLC3InF2AziCT6nk5wI1g0CB5o';
    public function send(Request $request){
    	$userid = intval(auth()->user()->id);
    	$post = json_decode(json_encode($request->all()), true);
    	$id_task = 0;
    	if (!empty($post)) {
            if (isset($post['id'])) {
				$id_task = intval(explode("_", $post['id'])[1]);
            }
        }
        if ( !empty($id_task) ) {
        	$chat_id = User::select('chat_id')->where('id', "=", $userid)->get()->toArray();
        	$chat_id = strval($chat_id[0]['chat_id']);
        	if (!empty($chat_id)) {
        		$text = TasksMain::select('task')->where([
                                                                    ['userid', "=", $userid], 
                                                                    ['id', "=", $id_task]
                                                                ])->get()->toArray();
	        	$text = base64_decode($text[0]['task']);
	        	$this->sendToTg($chat_id, $text);
	        	return 1;
        	}
        	
        }
	    return 0;
    }

    private function sendToTg($chat_id, $text){
    	$ch = curl_init();
	    curl_setopt_array(
	        $ch,
	        array(
	            CURLOPT_URL => 'https://api.telegram.org/bot' . self::TELEGRAM_TOKEN . '/sendMessage',
	            CURLOPT_POST => TRUE,
	            CURLOPT_RETURNTRANSFER => TRUE,
	            CURLOPT_TIMEOUT => 10,
	            CURLOPT_POSTFIELDS => array(
	                'chat_id' => $chat_id,
	                'text' => $text,
	            ),
	        )
	    );
	    curl_exec($ch);
    }
}