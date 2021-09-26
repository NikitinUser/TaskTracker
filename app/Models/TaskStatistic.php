<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Model;

class TaskStatistic extends Model
{
	protected $table = 'tasks_statistic';

	public function getCountDoneTasksFromStatistic()
    {
        $userid = intval(auth()->user()->id);

        $count = $this->select('doneTasks')
                      ->where([
                                ['userid', "=", $userid]
                        ])
                      ->get()
                      ->first();
        
        $count = $count->doneTasks ?? 0;              
        return $count;
    }

    public function commitDoneTaskToStatistic()
    {
    	$userid = intval(auth()->user()->id);

    	$this->where([
                        ['userid', "=", $userid]
                    ])
             ->increment('doneTasks', 1);

        return true;
    }

    public function addStatisticOfDoneTasksToUser($id)
    {
    	$this->insert([
                        'userid'    =>  $id,
                        'doneTasks' =>  0
        ]);

    }
}