<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TasksMain extends Model
{
    use HasFactory;

    protected $table = 'tasks_mains';

    protected $morphClass = 'TasksMain';

    protected $dbFields = [
                            'id'        =>  'id',
                            'dt_task'   =>  'dt_task',
                            'task'      =>  'task',
                            'userid'    =>  'userid',
                            'type'      =>  'type',
                            'priority'  =>  'priority'
                        ];
    private $id_task;
    private $type_task;
    private $priority_task;

    public function setType($type)
    {
        $this->type_task = $type;
    }

    public function setPriority($priority)
    {
        $this->priority_task = $priority;
    }


    public function allTasksUser($type)
    {
        $userid = intval(auth()->user()->id);

        $tasks = self::select('task', 'id', 'dt_task')->where([
                                                                ['userid', "=", $userid], 
                                                                ['type', "=", $type]
                                                            ])->orderBy('dt_task', 'asc')->get()->toArray();

        for ($i = 0; $i < count($tasks); $i++) {

            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);

        }

        return $tasks;
    }

    public function addNewTask($post)
    {
        $userid = intval(auth()->user()->id);

        $post['userid'] = $userid;

        $task = trim($post['task']);
        $task = mb_substr($task, 0, 700);
        $task = str_replace(["\"", "\'", "<!"], "", $task);
        $task = base64_encode($task);

        $post['task'] = $task;

        $post['id'] = self::insertGetId(
                        [
                            'task'      =>  $post['task'], 
                            'userid'    =>  $post['userid'],
                            'dt_task'   =>  $post['date'],
                            'type'      =>  $this->type_task,
                            'priority'  =>  $this->priority_task
                        ]
        );

        return $post;
    }

    public function swapTypeTask($post)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $affected = self::where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $id],
                                ])->update(['type' => $this->type_task, 'dt_task' => $post['date'] ]);
        return true;
    }

    public function removeTask($post)
    {
        $userid = intval(auth()->user()->id);

        $id = intval($post['id']);

        $affected = self::where([
                                    ['userid', "=", $userid], 
                                    ['id', '=', $id]
                                ])->delete();

        return true;
    }
}
