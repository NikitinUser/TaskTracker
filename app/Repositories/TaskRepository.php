<?php
namespace App\Repositories;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TaskRepository extends Model implements TaskRepositoryInterface
{

    protected $table = 'tasks_mains';
    protected $fillable = ['task', 'id', 'dt_task', 'priority', 'userid', 'type', 'created_at', 'updated_at'];

    public const TYPE_ACTIVE_TASK = 0;
    public const TYPE_DONE_TASK = 1;
    public const TYPE_ARCHIVE_TASK = 2;
    public const TYPE_BOOKMARK = 3;

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