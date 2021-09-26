<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\TaskRepository;
use App\Models\TaskStatistic;
use Illuminate\Support\Facades\Log;

class TaskStatisticController extends Controller
{
	private $TeskRepo;
    private $TaskStatistic;

	public function __construct()
    {
        $this->middleware('auth');
        $this->TeskRepo = new TaskRepository();
        $this->TaskStatistic = new TaskStatistic();
    }

    public function index()
    {
        return view('statistic'); 
    }

    public function getCounTasks()
    {
    	$countActive = $this->TeskRepo->getCountTasks($this->TeskRepo::TYPE_ACTIVE_TASK);
    	$countArchive = $this->TeskRepo->getCountTasks($this->TeskRepo::TYPE_ARCHIVE_TASK);
    	$countDone = $this->TaskStatistic->getCountDoneTasksFromStatistic();

    	$data = [
    			 'countActive'  => $countActive,
    			 'countDone' 	=> $countDone,
    			 'countArchive' => $countArchive
    	];

    	$data = json_encode($data);

    	return $data;
    }
}