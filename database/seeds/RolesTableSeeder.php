<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      try {
          \DB::connection()->getPdo()->beginTransaction();

          $permissions = array(
            ['code'=>'p_all', 'path_regex' => '.*', 'description' => ''], 
            ['code'=>'p_n_user', 'path_regex' => '.*', 'description' => ''], 
          );

          $permissions2 = [];

          foreach($permissions as $permission){
            array_push($permissions2, Permission::create($permission));
          }

          $roles = array(
            ['code'=>'admin', 'description' => 'Administrador'], // 1
            ['code'=>'agent', 'description' => 'Agente'],
          );

          $roles2 = [];

          foreach($roles as $role){
            array_push($roles2, Role::create($role));
          }

          $permissionRoles = array(
            ['permission_id'=>$permissions2[0]->id,'role_id'=>$roles2[0]->id],
            ['permission_id'=>$permissions2[1]->id,'role_id'=>$roles2[1]->id]
          );

          foreach($permissionRoles as $permissionRole){
            PermissionRole::create($permissionRole);
          }

          \DB::connection()->getPdo()->commit();
      } catch (\PDOException $e) {
          \DB::connection()->getPdo()->rollBack();
      }
    }
}
