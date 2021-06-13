<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use App\Repositories\TaskRepository;

class TasksMain extends TaskRepository
{
    public const MAX_COUNT_TASK_INTYPE = 50;

    public function addNewTask($post)
    {
        $post['userid'] = intval(auth()->user()->id);

        $task = preg_replace('/[^A-Za-z А-Яа-я 0-9 ;.,-=+]/ui', "", $post['task']);
        $task = trim($post['task']);
        $task = mb_substr($task, 0, 900);
        $task = base64_encode($task);

        $post['task'] = $task;

        $dt_task = new \DateTime($post['date']);
        $post['date'] = $dt_task->format('Y-m-d H:i:s');

        $newTask = TasksMain::create([
            'task'      =>  $post['task'], 
            'userid'    =>  $post['userid'],
            'dt_task'   =>  $post['date'],
            'type'      =>  $post['type'],
            'priority'  =>  $post['priorityTask']
         ]);

        $post['id'] = $newTask->id;
        
        return $post;
    }

    public function changeTask($post)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $task = preg_replace('/[^A-Za-z А-Яа-я 0-9 ;.,-=+]/ui', "", $post['task']);
        $task = trim($post['task']);
        $task = mb_substr($task, 0, 900);
        $task = base64_encode($task);

        $post['task'] = $task;

        $affected = $this->where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $id],
                                ])
                         ->update(['task' => $post['task'], 'priority' => $post['priorityTask'] ]);
        return true;
    }

    public function swapTypeTask($post)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $dt_task = new \DateTime($post['date']);
        $post['date'] = $dt_task->format('Y-m-d H:i:s');

        $model = $this->where([
                        ['userid', "=", $userid]
                    ])->find($id);

        if (empty($model)) {
            return false;
        }
        
        $model->update(['type' => $post['type'], 'dt_task' => $post['date'] ]);

        return true;
    }

    public function removeTask($post)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $affected = $this->where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $id]
                                ])
                         ->delete();

        return true;
    }
}
