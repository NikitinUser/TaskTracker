<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        $chat_id = User::select('chat_id')->where('id', "=", $userid)->get()->toArray();
        $chat_id = intval($chat_id[0]['chat_id']);
        if (empty($chat_id)) {
            $chat_id = "";
        }

        return view('settings', compact('chat_id') );	
    }

    public function save(Request $request)
    {
        $userid = intval(auth()->user()->id);

        $data = $request->all();
        Log::info("save settings:: user = " . $userid . ", data = " . json_encode($data));
        $chat_id = intval($data['chat_id']);
        if (empty($chat_id)) {
            return redirect()->route('settings')->withErrors('Неверный формат chat id');
        }

        $affected = User::where('id', "=", $userid)->update(['chat_id' => $chat_id]);
        return redirect()->route('settings')->withSuccess('chat id сохранен');
    }

    public function deleteUser()
    {
        $userid = intval(auth()->user()->id);
        return redirect()->back();
    }
}
