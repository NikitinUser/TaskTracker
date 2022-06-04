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

    public function getCounTasks()
    {
		$statisticService = new TaskStatisticService();

		$data = $statisticService->getCounTasks();

		$data = json_encode($data);

    	return $data;
    }
}