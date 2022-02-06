<?php
namespace NikitinUser\userManagementModule\lib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use NikitinUser\userManagementModule\lib\Models\Permission;

class PermissionController extends Controller
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->middleware('auth');
        $this->permission = $permission;
    }

    public function getPageAddPermission()
    {
        return view('user-management-module::permission.addPermission');
    }

    public function getPageEditPermission(Request $request)
    {
        $idPermission = $request->input("permission_id");

        $data = $this->permission->getPermission($idPermission);

        return view('user-management-module::permission.editPermission', compact('data'));
    }

    public function addPermission(Request $request)
    {
        $data = [];
        $data['permission_name'] = $request?->input('permission_name');
        $this->permission->addPermission($data);

        return redirect(route("getPageAllRoles"));
    }

    public function editPermission(Request $request)
    {
        $idPermission = $request->input("permission_id");
        $name_permission = $request->input("permission_name");

        $this->permission->updatePermission($idPermission, $name_permission);

        return redirect(route("getPageAllRoles"));
    }

    public function deletePermission(Request $request)
    {
        $idPermission = $request->input("id_permission") ?? 0;
        $this->permission->deletePermission($idPermission);

        return true;
    }
}