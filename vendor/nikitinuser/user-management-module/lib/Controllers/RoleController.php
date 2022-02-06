<?php
namespace NikitinUser\userManagementModule\lib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use NikitinUser\userManagementModule\lib\Models\PermissionsForRole;
use NikitinUser\userManagementModule\lib\Models\RolesForUser;
use NikitinUser\userManagementModule\lib\Models\Role;

class RoleController extends Controller
{
    private $role;

    public function __construct(Role $role)
    {
        $this->middleware('auth');
        $this->role = $role;
    }

    public function getPageAllRoles()
    {
        $pfr = new PermissionsForRole();
        $data = $pfr->getAllRolesAndPermissions();
        //dd($data);
        
        return view('user-management-module::role.rolesAndPermissions', compact('data'));
    }

    public function getPageUsersRoles()
    {
        $pfr = new RolesForUser();
        $data = $pfr->getAllUsersAndRoles();
        //dd($data);

        return view('user-management-module::role.usersRoles', compact('data'));
    }

    public function getPageAddRole()
    {
        return view('user-management-module::role.addRole');
    }

    public function getPageEditRole(Request $request)
    {
        $idRole = $request->input("role_id");
        
        $data = $this->role->getRole($idRole);

        return view('user-management-module::role.editRole', compact('data'));
    }

    public function addRole(Request $request)
    {
        $data = [];
        $data['role_name'] = $request?->input('role_name');
        $this->role->addRole($data);

        return redirect(route("getPageAllRoles"));
    }

    public function editRole(Request $request)
    {
        $idRole = $request->input("role_id");
        $name_role = $request->input("role_name");

        $this->role->updateRole($idRole, $name_role);

        return redirect(route("getPageAllRoles"));
    }

    public function deleteRole(Request $request)
    {
        $roleId = $request->input("id_role") ?? 0;
        $this->role->deleteRole($roleId);

        return true;
    }

    public function addPermissionForRole(Request $request)
    {
        $role_id = $request->input("id_role");
        $permission_id = $request->input("id_permission");

        $pfr = new PermissionsForRole();
        $data = $pfr->addPermissionForRole($role_id, $permission_id);

        return true;
    }

    public function removePermissionForRole(Request $request)
    {
        $role_id = $request->input("id_role");
        $permission_id = $request->input("id_permission");

        $pfr = new PermissionsForRole();
        $data = $pfr->removePermissionForRole($role_id, $permission_id);

        return true;
    }
}