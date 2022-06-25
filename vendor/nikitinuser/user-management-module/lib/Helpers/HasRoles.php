<?php 
namespace NikitinUser\userManagementModule\lib\Helpers;

use NikitinUser\userManagementModule\lib\Services\UserService;

trait HasRoles
{
    public function hasRole(string $role): bool
    {
        $userId = (int)auth()->user()->id;
        
        $userService = new UserService();

        return $userService->hasRole($userId, $role);
    }
}
