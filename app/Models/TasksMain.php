<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksMain extends Model
{
    use HasFactory;

    protected $table = 'tasks_mains';

    protected $morphClass = 'TasksMain';

    public function add($data){
        TasksMain::insertGetId(
            [
                'task'       => $data['task'], 
                'userid'     => $data['userid']
            ]
        );
    }
}
