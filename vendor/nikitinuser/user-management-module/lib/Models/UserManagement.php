<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserManagement extends Model
{
    protected $table = 'users';

    public function getAll()
    {
        $columns = ["id", "login", "block", "last_session", "created_at"];
        return $this->select($columns)
             ->get()
             ->toArray();
    }

    public function deleteRole($userId)
    {
        DB::table('roles_for_user')
                ->where('id_user', '=', $userId)
                ->delete();

        $this->where('id', $userId)->delete();
    }
}