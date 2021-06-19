<?php

namespace App\Observers;

use App\Models\User;
use App\Models\TaskStatistic;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $TaskStatistic = new TaskStatistic();
        $TaskStatistic->addStatistic($user->id);
        unset($TaskStatistic);
    }
}
