<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleList = [
        	[
        		'name' => 'administrator',
        		'display_name' => 'Administrator'
        	],
        	[
        		'name' => 'employee',
        		'display_name' => 'Employee'
        	]
        ];

        for($counter = 0; $counter < count($roleList); $counter++){
        	$role = new Role();
        	$role->name = $roleList[$counter]['name'];
        	$role->display_name = $roleList[$counter]['display_name'];
        	$role->save();
        }
    }
}
