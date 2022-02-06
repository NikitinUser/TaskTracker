<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Permission extends Model
{
    protected $table = 'permissions';

    public function addPermission($permissionData)
    {
        $this->insert($permissionData);
    }

    public function getAll()
    {
        return $this->select()
             ->get()
             ->toArray();
    }

    public function getPermission($idPermission)
    {
        return $this->select()
             ->where("id", $idPermission)
             ->get()
             ->toArray();
    }

    public function updatePermission($idPermission, $name_permission)
    {
        $this->where('id', $idPermission)
        ->update(['permission_name' => $name_permission]);
    }

    public function deletePermission($idPermission)
    {
        DB::table('permissions_for_role')
                ->where('id_permission', '=', $idPermission)
                ->delete();

        $this->where('id', $idPermission)->delete();
    }
}