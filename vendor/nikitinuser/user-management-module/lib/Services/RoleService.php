<?php 
namespace NikitinUser\userManagementModule\lib\Services;

use NikitinUser\userManagementModule\lib\Models\Role;
use NikitinUser\userManagementModule\lib\Models\RolesForUser;

class RoleService
{
    private Role $role;
    private RolesForUser $rolesForUser;

    public function __construct()
    {
        $this->role = new Role();
        $this->rolesForUser = new RolesForUser();
    }

    public function getAllRoles()
    {
        return $this->role->get();
    }

    public function getRoleById(int $id): ?Role
    {
        return $this->role
            ->where("id", $id)
            ->first();
    }

    public function getAllRolesForUsers()
    {
        return $this->rolesForUser->getAllUsersWithRoles();
    }

    public function addRoleForUser(int $roleId, int $userId): ?RolesForUser
    {
        return $this->rolesForUser->create(
            [
                "id_role" => $roleId,
                "id_user" => $userId,
            ]
        );
    }

    public function removeRoleForUser(int $roleId, int $userId): void
    {
        $this->rolesForUser
            ->where('id_role', '=', $roleId)
            ->where('id_user', '=', $userId)
            ->delete();
    }

    public function addRole(array $roleData): ?Role
    {
        return $this->role->create($roleData);
    }

    public function updateRole(int $idRole, string $nameRole): void
    {
        $this->role->where('id', $idRole)
            ->update(['role_name' => $nameRole]);
    }

    public function deleteRole(int $roleId): void
    {
        $this->role->where('id', $roleId)
            ->delete();
    }

    public function getByRoleAndUserId(int $userId, string $role): ?array
    {
        return $this->rolesForUser->getByRoleAndUserId($userId, $role);
    }

    public function getByPermissionAndUserId(int $userId, string $permission): ?array
    {
        return $this->rolesForUser->getByPermissionAndUserId($userId, $permission);
    }
}
