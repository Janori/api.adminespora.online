<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
      $roles = array(
        ['code'=>'admin', 'description' => 'Administrador'], // 1
        ['code'=>'spruser', 'description' => 'Super usuario'],
        ['code'=>'user', 'description' => 'Usuario'],
        ['code'=>'spuser', 'description' => 'Usuario especial'],
      );

      foreach($roles as $role){
        Roles::create($role);
      }
    }
}
