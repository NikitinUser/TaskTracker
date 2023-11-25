<?php

return [
    'model' => \App\Models\User::class,
    'columns' => ['users.id', 'users.email', 'users.created_at'],
    'primary_key' => 'id',
    'table' => 'users',
    'roles' => ['admin', 'user'],
];
