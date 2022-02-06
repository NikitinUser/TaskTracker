<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\TaskRepository;
use App\Models\TaskStatistic;
use Illuminate\Support\Facades\Log;

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

    public function getCounTasks(TaskRepository $tasksRepository, TaskStatistic $taskStatistic)
    {
    	$countActive = $tasksRepository->getCountTasks($tasksRepository::TYPE_ACTIVE_TASK);
    	$countArchive = $tasksRepository->getCountTasks($tasksRepository::TYPE_ARCHIVE_TASK);
    	$countDone = $taskStatistic->getCountDoneTasksFromStatistic();

    	$data = [
    			 'countActive'  => $countActive,
    			 'countDone' 	=> $countDone,
    			 'countArchive' => $countArchive
    	];

    	$data = json_encode($data);

    	return $data;
    }
}