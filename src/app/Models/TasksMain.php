<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksMain extends Model
{
    public const MAX_COUNT_TASKS_INTYPE = 50;

    public const TYPE_ACTIVE_TASK = 0;
    public const TYPE_DONE_TASK = 1;
    public const TYPE_ARCHIVE_TASK = 2;
    public const TYPE_BOOKMARK = 3;
    public const TYPES_ARRAY_ID = [0, 1, 2, 3];

    protected $table = 'tasks_mains';

    protected $fillable = [
        'task',
        'id',
        'dt_task',
        'userid',
        'type',
        'created_at',
        'updated_at'
    ];
    
    /**
     * getTaskById
     *
     * @param  int $id
     * @return TasksMain|null
     */
    public function getTaskById(int $id): ?TasksMain
    {
        return $this->where("id", $id)->get()->first();
    }
    
    /**
     * getTasksByUseridAndType
     *
     * @param  int $userid
     * @param  int $type
     * @return array|null
     */
    public function getTasksByUseridAndType(int $userid, int $type): ?array
    {
        $where = [
            'userid' => $userid,
            'type' => $type
        ];

        return $this->where($where)
            ->orderBy('dt_task', 'asc')
            ->get()
            ->toArray();
    }
    
    /**
     * getCountTasksByUseridAndType
     *
     * @param  int $userid
     * @param  int $type
     * @return int
     */
    public function getCountTasksByUseridAndType(int $userid, int $type): int
    {
        $where = [
            'userid' => $userid,
            'type' => $type
        ];

        return $this->where($where)
            ->get()
            ->count();
    }
}
