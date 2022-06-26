<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class TaskStatistic extends Model
{
	protected $table = 'tasks_statistic';

    protected $fillable = [
        'id',
        'doneTasks',
        'userid'
    ];
	
	/**
	 * getStatisticByUserid
	 *
	 * @param  int $userid
	 * @return TaskStatistic|null
	 */
	public function getStatisticByUserid(int $userid): ?TaskStatistic
    {
        return $this->where('userid', $userid)
            ->get()
            ->first();
    }
    
    /**
     * incrementDoneTasks
     *
     * @param  int $userid
     * @return bool
     */
    public function incrementDoneTasks(int $userid): bool
    {
    	return $this->where('userid', $userid)
            ->increment('doneTasks', 1);
    }
}