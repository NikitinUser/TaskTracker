<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use App\Repositories\TaskRepository;

class TasksMain extends TaskRepository
{
    public function addNewTask($post, $typeTask)
    {
        $post['userid'] = intval(auth()->user()->id);

        $task = preg_replace('/[^A-Za-z А-Яа-я 0-9 ;.,-=+]/ui', "", $post['task']);
        $task = trim($post['task']);
        $task = mb_substr($task, 0, 700);
        $task = base64_encode($task);

        $post['task'] = $task;

        $dt_task = new \DateTime($post['date']);
        $post['date'] = $dt_task->format('Y-m-d H:i:s');

        $post['id'] = $this->insertGetId(
                        [
                            'task'      =>  $post['task'], 
                            'userid'    =>  $post['userid'],
                            'dt_task'   =>  $post['date'],
                            'type'      =>  $typeTask,
                            'priority'  =>  $post['priorityTask']
                        ]
        );

        return $post;
    }

    public function swapTypeTask($post, $typeTask)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $dt_task = new \DateTime($post['date']);
        $post['date'] = $dt_task->format('Y-m-d H:i:s');

        $affected = $this->where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $id],
                                ])
                         ->update(['type' => $typeTask, 'dt_task' => $post['date'] ]);
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
