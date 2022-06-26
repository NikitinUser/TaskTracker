<?php

namespace App\Http\Controllers;

use App\Services\TaskStatisticService;

class TaskStatisticController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('statistic'); 
    }

    public function getCountTasks()
    {
		$statisticService = new TaskStatisticService();

        $userid = (int)auth()->user()->id;

		$data = $statisticService->getCountTasks($userid);

		$data = json_encode($data);

    	return $data;
    }
}