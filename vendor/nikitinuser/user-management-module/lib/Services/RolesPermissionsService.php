<?php 
namespace NikitinUser\userManagementModule\lib\Services;

use NikitinUser\userManagementModule\lib\Models\PermissionsForRole;
use NikitinUser\userManagementModule\lib\Services\PermissionService;
use NikitinUser\userManagementModule\lib\Services\RoleService;

class RolesPermissionsService
{
    private RoleService $roleService;
    private PermissionService $permissionService;
    private PermissionsForRole $permissionsRoles;

    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->permissionService = new PermissionService();
        $this->permissionsRoles = new PermissionsForRole();
    }

    public function getPermissionsAndRoles(): array
    {
        $rolesAndPermissions = $this->permissionsRoles->getAllPermissionsForRoles();
        $permissions = $this->permissionService->getAllPermissions();
        $roles = $this->roleService->getAllRoles();

        $response = [
            'roles' => $roles,
            'permissions' => $permissions,
            'rolesAndPermissions' => $rolesAndPermissions
        ];

        return $response;
    }

    public function addPermissionForRole(int $roleId, int $permissionId): void
    {
        $this->permissionsRoles->create([
            'id_role' => $roleId,
            'id_permission' => $permissionId
        ]);
    }

    public function removePermissionForRole(int $roleId, int $permissionId): void
    {
        $this->permissionsRoles->where('id_role', '=', $roleId)
            ->where('id_permission', '=', $permissionId)
            ->delete();
    }
}
