<?php
namespace NikitinUser\userManagementModule\lib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NikitinUser\userManagementModule\lib\Services\PermissionService;
use NikitinUser\userManagementModule\lib\Services\RolesPermissionsService;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    private PermissionService $permissionService;
    private RolesPermissionsService $rolePermissionService;

    public function __construct()
    {
        $this->middleware('role:admin');
        $this->permissionService = new PermissionService();
        $this->rolePermissionService = new RolesPermissionsService();
    }

    public function getPageAllRolesAndPermissions()
    {
        $data = $this->getAllRolesAndPermission();
        return view('user-management-module::rolesAndPermissions', compact('data'));
    }

    public function getAllRolesAndPermission()
    {
        return $this->rolePermissionService->getPermissionsAndRoles();
    }

    public function getPageAddPermission()
    {
        return view('user-management-module::permission.addPermission');
    }

    public function getPageEditPermission(Request $request)
    {
        $permission = $this->getPermissionData($request);

        return view('user-management-module::permission.editPermission', compact('permission'));
    }

    public function getPermissionData(Request $request)
    {
        $idPermission = (int)$request->input("permission_id");

        return $this->permissionService->getPermissionById($idPermission);
    }

    public function addPermission(Request $request)
    {
        $permissionData = $request->all();
        $permission = $this->permissionService->addPermission($permissionData);

        return json_encode($permission);
    }

    public function editPermission(Request $request)
    {
        $idPermission = (int)$request->input("permission_id");
        $namePermission = $request->input("permission_name");

        $this->permissionService->updatePermissionNameById($idPermission, $namePermission);
    }

    public function deletePermission(Request $request)
    {
        $idPermission = $request->input("permission_id") ?? 0;
        $this->permissionService->deletePermission($idPermission);
    }

    public function addPermissionForRole(Request $request)
    {
        $roleId = (int)$request?->input("id_role");
        $permissionId = (int)$request?->input("id_permission");

        $this->rolePermissionService->addPermissionForRole($roleId, $permissionId);
    }

    public function removePermissionForRole(Request $request)
    {
        $roleId = (int)$request?->input("id_role");
        $permissionId = (int)$request?->input("id_permission");

        $this->rolePermissionService->removePermissionForRole($roleId, $permissionId);
    }
}
