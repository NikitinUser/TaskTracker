<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;

use NikitinUser\userManagementModule\lib\Models\UserManagement;
use NikitinUser\userManagementModule\lib\Models\Role;

class RolesForUser extends Model
{
    protected $table = 'roles_for_user';

    public function getAllUsersAndRoles()
    {
        $columnsRolesForUsers = ['roles_for_user.id as id', 'roles.id as role_id', 'users.id as user_id'];

        $rolesForUsers = $this->select($columnsRolesForUsers)
                  ->join('roles', 'roles_for_user.id_role', '=', 'roles.id')
                  ->join('users', 'roles_for_user.id_user', '=', 'users.id')
                  ->get()
                  ->toArray();

        $users = new UserManagement();
        $allUsers = $users->getAll();

        $role = new Role();
        $allRoles = $role->getAll();

        $allUsers = $this->fillAllUsers($allUsers, $allRoles, $rolesForUsers);

        $response = [
            'users' => $allUsers,
            'roles' => $allRoles
        ];

        return $response;
    }

    private function fillAllUsers($allUsers, $allRoles, $rolesForUsers)
    {
        $arrActiveRoles = [];
        foreach ($rolesForUsers as $key => $value) {
            if (!isset($arrActiveRoles[$value['user_id']]))
                $arrActiveRoles[$value['user_id']] = [];

            if (!in_array($value['role_id'], $arrActiveRoles[$value['user_id']]))
                $arrActiveRoles[$value['user_id']][] = $value['role_id'];
        }

        for ($i = 0; $i < count($allUsers); $i++) {
            $allUsers[$i]['status'] = [];

            foreach ($allRoles as $key => $value) {

                if (isset($arrActiveRoles[$allUsers[$i]['id']])) {
                    if (in_array($value['id'], $arrActiveRoles[$allUsers[$i]['id']])) {
                        $allUsers[$i]['status'][$value['id']] = 1;
                    } else {
                        $allUsers[$i]['status'][$value['id']] = 0;
                    } 
                } else {
                    $allUsers[$i]['status'][$value['id']] = 0;
                }

            }
        }   

        return $allUsers;
    }

    public function addRoleForUser($role_id, $user_id)
    {
        $this->insert([
            'id_role' => $role_id,
            'id_user' => $user_id
        ]);
    }

    public function removeRoleForUser($role_id, $user_id)
    {
        $this->where('id_role', '=', $role_id)
             ->where('id_user', '=', $user_id)
             ->delete();
    }
}