<?php
namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TaskRepository extends Model implements TaskRepositoryInterface
{

    protected $table = 'tasks_mains';

    public function allTasksUser($type)
    {
        $userid = intval(auth()->user()->id);

        $columns = ['task', 'id', 'dt_task', 'priority'];

        $tasks = $this->select($columns)
                      ->where([
                                ['userid', "=", $userid], 
                                ['type', "=", $type]
                        ])
                      ->orderBy('dt_task', 'asc')
                      ->get()
                      ->toArray();

        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }

        return $tasks;
    }
}