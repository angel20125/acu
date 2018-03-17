<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Role Admin
      	$admin = new Role();
      	$admin->name = 'admin';
      	$admin->display_name = 'Admin';
      	$admin->save();

    	//Súper Admin
      	$user = new User();
      	$user->identity_card = 'admin';
      	$user->first_name = 'admin';
      	$user->last_name = 'admin';
      	$user->phone_number = 'admin';
      	$user->email = 'admin_acu@gmail.com';
      	$user->password = 'admin1234';
      	$user->save();
      	$user->attachRole($admin);

      //Role Presidente
        $adjunto = new Role();
        $adjunto->name = 'presidente';
        $adjunto->display_name = 'Presidente';
        $adjunto->save();

    	//Role Consejero
      	$consejero = new Role();
      	$consejero->name = 'consejero';
      	$consejero->display_name = 'Consejero';
      	$consejero->save();

    	//Role Secretaria
      	$secretaria = new Role();
      	$secretaria->name = 'secretaria';
      	$secretaria->display_name = 'Secretaria';
      	$secretaria->save();

    	//Role Adjunto
      	$adjunto = new Role();
      	$adjunto->name = 'adjunto';
      	$adjunto->display_name = 'Adjunto';
      	$adjunto->save();
    }
}
