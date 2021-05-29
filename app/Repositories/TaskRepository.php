<?php
namespace App\Repositories;


use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TaskRepository extends Model implements TaskRepositoryInterface
{

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

    public function allTasksUser($type)
    {
        $userid = intval(auth()->user()->id);

        $tasks = self::select('task', 'id', 'dt_task', 'priority')->where([
                                                                            ['userid', "=", $userid], 
                                                                            ['type', "=", $type]
                                                                        ])->orderBy('dt_task', 'asc')->get()->toArray();

        for ($i = 0; $i < count($tasks); $i++) {

            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);

        }

        return $tasks;
    }
}