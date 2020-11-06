<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


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

    public function send_tasks(){
      $token = "1445980108:AAFCAXQvtQLC3InF2AziCT6nk5wI1g0CB5o";
      $chat_id = "995126233";
      $ch = curl_init();
      curl_setopt_array(
          $ch,
          array(
              CURLOPT_URL => 'https://api.telegram.org/bot' . $token . '/sendMessage',
              CURLOPT_POST => TRUE,
              CURLOPT_RETURNTRANSFER => TRUE,
              CURLOPT_TIMEOUT => 10,
              CURLOPT_POSTFIELDS => array(
                  'chat_id' => $chat_id,
                  'text' => "test",
              ),
          )
      );
      curl_exec($ch);
    }
}
