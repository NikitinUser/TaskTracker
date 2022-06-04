<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class TasksMain extends Model
{
    public const MAX_COUNT_TASKS_INTYPE = 50;

    public const TYPE_ACTIVE_TASK = 0;
    public const TYPE_DONE_TASK = 1;
    public const TYPE_ARCHIVE_TASK = 2;
    public const TYPE_BOOKMARK = 3;

    protected $table = 'tasks_mains';

    protected $fillable = [
        'task',
        'id',
        'dt_task',
        'priority',
        'userid',
        'type',
        'created_at',
        'updated_at'
    ];

    public function addNewTask($task)
    {
        $task['userid'] = intval(auth()?->user()?->id);

        if (empty($task['userid'])) {
            return [];
        }

        $task['task'] = trim($task['task']);
        $task['task'] = base64_encode($task['task']);

        $dt_task = new \DateTime($task['date']);
        $task['date'] = $dt_task->format('Y-m-d H:i:s');

        $newTask = TasksMain::create([
            'task'      =>  $task['task'], 
            'userid'    =>  $task['userid'],
            'dt_task'   =>  $task['date'],
            'type'      =>  $task['type'],
            'priority'  =>  $task['priorityTask']
         ]);

        $task['id'] = $newTask->id;
        
        return $task;
    }

    public function rewriteTask($task)
    {
        $userid = intval(auth()->user()->id);

        $task['task'] = trim($task['task']);
        $task['task'] = base64_encode($task['task']);

        $affected = $this->where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $task['id']],
                                ])
                         ->update(['task' => $task['task'], 'priority' => $task['priorityTask'] ]);
        return true;
    }

    public function swapTheTypeOfTask($task)
    {
        $userid = intval(auth()->user()->id);

        $dt_task = new \DateTime($task['date']);
        $task['date'] = $dt_task->format('Y-m-d H:i:s');

        $model = $this->where([
                        ['userid', "=", $userid]
                    ])->find($task['id']);

        if (empty($model)) {
            return false;
        }
        
        $model->update(['type' => $task['type'], 'dt_task' => $task['date'] ]);

        return true;
    }

    public function removeTask($taskID)
    {
        $userid = intval(auth()->user()->id);

        $taskID = intval($taskID);

        $model = $this->where([
                                ['userid', "=", $userid]
                            ])
                      ->find($taskID);

        if (empty($model)) {
            return false;
        }

        $model->delete();

        return true;
    }

    public function recoverTask($taskID)
    {
        $userid = intval(auth()->user()->id);

        $key = "task_" . $taskID . "_" . $userid;

        $taskInRedis = Redis::get($key);

        if (!$taskInRedis) {
            return false;
        }

        $task = json_decode($taskInRedis);

        if ($task->userid != $userid) {
            return false;
        }

        $this->insert([
            'id'        =>  $task->id, 
            'task'      =>  $task->task, 
            'userid'    =>  $task->userid,
            'dt_task'   =>  $task->dt_task,
            'type'      =>  $task->type,
            'priority'  =>  $task->priority
        ]);

        $task->task = base64_decode($task->task);
        
        return $task;
    }
}
