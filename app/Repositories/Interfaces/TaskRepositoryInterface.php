<?php
namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function getUserTasks($type);
    public function getCountTasks($type);
}