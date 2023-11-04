<?php 
namespace NikitinUser\userManagementModule\lib\Helpers;

use NikitinUser\userManagementModule\lib\Services\UserService;

trait HasPermissions
{
    public function hasPermission(string $permission): bool
    {
        $userId = (int)auth()->user()->id;
        
        $userService = new UserService();

        return $userService->hasPermission($userId, $permission);
    }
}
