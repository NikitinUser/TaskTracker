<?php
namespace NikitinUser\userManagementModule\lib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use NikitinUser\userManagementModule\lib\Models\UserManagement;
use NikitinUser\userManagementModule\lib\Models\RolesForUser;

class UserManagementController extends Controller
{
    private $userM;

    public function __construct(UserManagement $userM)
    {
        $this->middleware('auth');
        $this->userM = $userM;
    }

    public function getPageAllUsers()
    {
        $data = $this->userM->getAll();
        //dd($data);
        return view('user-management-module::user.allUsers', compact('data'));
    }

    public function getPageAddUser()
    {
        return view('user-management-module::user.addNewUser');
    }

    public function getPageUserInfo()
    {
        return view('user-management-module::user.userInfo');
    }

    public function removeUser(Request $request)
    {
        $userId = $request->input("id_user");
        $this->userM->deleteRole($userId);
    }

    public function addRoleForUser(Request $request)
    {
        $role_id = $request->input("id_role");
        $user_id = $request->input("id_user");

        $pfr = new RolesForUser();
        $data = $pfr->addRoleForUser($role_id, $user_id);

        return true;
    }

    public function removeRoleForUser(Request $request)
    {
        $role_id = $request->input("id_role");
        $user_id = $request->input("id_user");

        $pfr = new RolesForUser();
        $data = $pfr->removeRoleForUser($role_id, $user_id);

        return true;
    }
}