<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
	    $permissions = array(
	      ['code'=>'p_all', 'path_regex' => '.*', 'description' => ''],
	      ['code'=>'p_n_user', 'path_regex' => '.*', 'description' => ''],
	    );

	    foreach($permissions as $permission){
	      Permission::create($permission);
	    }
    }
}
