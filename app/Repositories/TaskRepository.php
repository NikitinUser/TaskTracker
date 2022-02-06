<?php
namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Models\TasksMain;
use Illuminate\Support\Facades\Log;

class TaskRepository extends TasksMain implements TaskRepositoryInterface
{
    public function getUserTasks($type)
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

        if (!is_array($tasks))
            return false;
                      
        for ($i = 0; $i < count($tasks); $i++) {
            $tasks[$i]['task'] = base64_decode($tasks[$i]['task']);
        }

        return $tasks;
    }

    public function getCountTasks($type)
    {
        $userid = intval(auth()->user()->id);

        $count = $this->select('id')
                      ->where([
                                ['userid', "=", $userid], 
                                ['type', "=", $type]
                        ])
                      ->get()
                      ->count();
        return $count;
    }
}