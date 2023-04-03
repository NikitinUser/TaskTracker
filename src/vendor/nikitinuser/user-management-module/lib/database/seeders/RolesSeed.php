<?php
namespace NikitinUser\userManagementModule\lib\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class RolesSeed extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('roles')->insert(['role_name' => 'admin',]);
        DB::table('roles')->insert(['role_name' => 'user']);
    }
}
