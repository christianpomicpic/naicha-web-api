<?php

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = new UserRole();
        $userRole->role_id = 1;
        $userRole->user_id = 1;
        $userRole->save();
    }
}
