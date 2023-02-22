<?php
namespace NikitinUser\userManagementModule\lib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NikitinUser\userManagementModule\lib\Services\RoleService;
use NikitinUser\userManagementModule\lib\Services\UserService;

class UserManagementController extends Controller
{
    private RoleService $roleService;
    private UserService $userService;

    public function __construct()
    {
        $this->middleware('role:admin');
        $this->roleService = new RoleService();
        $this->userService = new UserService();
    }

    public function getPageAllUsers()
    {
        $users = $this->getAllUsers();

        return view('user-management-module::user.allUsers', compact('users'));
    }

    public function getAllUsers()
    {
        return $this->userService->getAllUsers();
    }

    public function removeUser(Request $request)
    {
        $userId = (int)$request->input("id_user");
        $this->userService->deleteUserById($userId);
    }

    public function addRoleForUser(Request $request)
    {
        $roleId = (int)$request->input("id_role");
        $userId = (int)$request->input("id_user");

        $this->roleService->addRoleForUser($roleId, $userId);
    }

    public function removeRoleForUser(Request $request)
    {
        $roleId = (int)$request->input("id_role");
        $userId = (int)$request->input("id_user");

        $this->roleService->removeRoleForUser($roleId, $userId);
    }
}
