<?php 
namespace NikitinUser\userManagementModule\lib\Services;

use NikitinUser\userManagementModule\lib\Models\Permission;

class PermissionService
{
    private Permission $permission;

    public function __construct()
    {
        $this->permission = new Permission();
    }

    public function getAllPermissions()
    {
        return $this->permission->get();
    }

    public function getPermissionById(int $idPermission): ?Permission
    {
        return $this->permission
            ->where("id", $idPermission)
            ->first();
    }

    public function addPermission(array $permissionData): ?Permission
    {
        return $this->permission->create($permissionData);
    }

    public function updatePermissionNameById(int $idPermission, string $namePermission): void
    {
        $this->permission->where('id', $idPermission)
            ->update(['permission_name' => $namePermission]);
    }


    public function deletePermission(int $idPermission): void
    {
        $this->permission->where('id', $idPermission)
            ->delete();
    }
}
