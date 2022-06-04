<?php

namespace App\Observers;

use App\Models\User;
use App\Services\TaskStatisticService;

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
        $statisticService = new TaskStatisticService();
        $statisticService->addStatisticToUser($user->id);
        unset($statisticService);
    }
}
