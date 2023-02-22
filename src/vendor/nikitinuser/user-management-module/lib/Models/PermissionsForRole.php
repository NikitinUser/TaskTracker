<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionsForRole extends Model
{
    protected $table = 'permissions_for_role';

    protected $fillable = [
        'id_role',
        'id_permission',
    ];

    public function getAllPermissionsForRoles(): array
    {
        $columnsRolesAndPermissions = [
            'permissions_for_role.id as id',
            'roles.id as role_id',
            'permissions.id as permis_id'
        ];

        return $this->select($columnsRolesAndPermissions)
            ->rightJoin('roles', 'permissions_for_role.id_role', '=', 'roles.id')
            ->rightJoin('permissions', 'permissions_for_role.id_permission', '=', 'permissions.id')
            ->get()
            ->toArray();
        return $response;
    }
}
