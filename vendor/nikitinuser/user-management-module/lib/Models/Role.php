<?php 
namespace NikitinUser\userManagementModule\lib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'role_name',
    ];

    public function getAll(): array
    {
        return $this->get()
             ->toArray();
    }
}
