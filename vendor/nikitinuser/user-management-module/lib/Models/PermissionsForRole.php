<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;

use NikitinUser\userManagementModule\lib\Models\Permission;
use NikitinUser\userManagementModule\lib\Models\Role;

class PermissionsForRole extends Model
{
    protected $table = 'permissions_for_role';

    public function getAllRolesAndPermissions()
    {
        $columnsRolesAndPermissions = ['permissions_for_role.id as id', 'roles.id as role_id', 'permissions.id as permis_id'];

        $rolesAndPermissions = $this->select($columnsRolesAndPermissions)
                  ->join('roles', 'permissions_for_role.id_role', '=', 'roles.id')
                  ->join('permissions', 'permissions_for_role.id_permission', '=', 'permissions.id')
                  ->get()
                  ->toArray();

        $role = new Role();
        $allRoles = $role->getAll();

        $permission = new Permission();
        $allPermissions = $permission->getAll();

        $allRoles = $this->fillAllRoles($allRoles, $allPermissions, $rolesAndPermissions);

        $response = [
            'roles' => $allRoles,
            'permissions' => $allPermissions
        ];

        return $response;
    }

    private function fillAllRoles($allRoles, $allPermissions, $rolesAndPermissions)
    {
        $arrActivePermissions = [];
        foreach ($rolesAndPermissions as $key => $value) {
            if (!isset($arrActivePermissions[$value['role_id']]))
                $arrActivePermissions[$value['role_id']] = [];

            if (!in_array($value['permis_id'], $arrActivePermissions[$value['role_id']]))
                $arrActivePermissions[$value['role_id']][] = $value['permis_id'];
        }

        for ($i = 0; $i < count($allRoles); $i++) {
            $allRoles[$i]['status'] = [];

            foreach ($allPermissions as $key => $value) {

                if (isset($arrActivePermissions[$allRoles[$i]['id']])) {
                    if (in_array($value['id'], $arrActivePermissions[$allRoles[$i]['id']])) {
                        $allRoles[$i]['status'][$value['id']] = 1;
                    } else {
                        $allRoles[$i]['status'][$value['id']] = 0;
                    } 
                } else {
                    $allRoles[$i]['status'][$value['id']] = 0;
                }

            }
        }   

        return $allRoles;
    }

    public function addPermissionForRole($role_id, $permission_id)
    {
        $this->insert([
            'id_role' => $role_id,
            'id_permission' => $permission_id
        ]);
    }

    public function removePermissionForRole($role_id, $permission_id)
    {
        $this->where('id_role', '=', $role_id)
             ->where('id_permission', '=', $permission_id)
             ->delete();
    }
}