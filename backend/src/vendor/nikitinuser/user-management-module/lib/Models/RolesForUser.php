<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;

use NikitinUser\userManagementModule\lib\Models\UserManagement;
use NikitinUser\userManagementModule\lib\Models\Role;

class RolesForUser extends Model
{
    protected $table = 'roles_for_user';

    protected $fillable = [
        'id_role',
        'id_user',
    ];

    public function getAllUsersWithRoles(): array
    {
        return $this->leftJoin('roles', 'roles_for_user.id_role', '=', 'roles.id')
            ->leftJoin('users', 'roles_for_user.id_user', '=', 'users.id')
            ->get()
            ->toArray();
    }

    public function getByRoleAndUserId(int $userId, string $role): ?array
    {
        return $this->leftJoin('roles', 'roles_for_user.id_role', '=', 'roles.id')
            ->where('id_user', $userId)
            ->where('roles.role_name', $role)
            ->first()
            ?->toArray();
    }

    public function getByPermissionAndUserId(int $userId, string $permission): ?array
    {
        return $this->leftJoin('roles', 'roles_for_user.id_role', '=', 'roles.id')
            ->leftJoin('permissions_for_role', 'permissions_for_role.id_role', '=', 'roles.id')
            ->leftJoin('permissions', 'permissions_for_role.id_permission', '=', 'permissions.id')
            ->where('id_user', $userId)
            ->where('permissions.permission_name', $permission)
            ->first()
            ?->toArray();
    }
}
