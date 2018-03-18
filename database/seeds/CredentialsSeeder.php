<?php

/**
 *  @package        ACU.Database.Seeds.CredentialsSeeder
 *  
 *  @author         Estudiantes de Ingeniería En Informática / 2017-II 
 *  @copyright      Todos los derechos reservados. ACU. 2018.
 *  
 *  @since          Versión 1.0, revisión 17-03-2018.
 *  @version        1.0
 * 
 *  @final  
 */

/**
 * Incluye la implementación de los siguientes Servicios y Modelos
 */

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\User;


/**
 *  Seeder Credenciales
 */

class CredentialsSeeder extends Seeder
{
    /**
     * Función que almacena las credenciales de los usuarios predeterminados en la BD.
     *
     * @return void
     */
    public function run()
    {
		$data = ['credentials' => [

			//Súper Admin
			['identity_card' 	=> 'admin',
			 'first_name' 		=> 'admin', 
			 'last_name' 		=> 'admin', 
			 'phone_number' 	=> 'admin', 
			 'email' 			=> 'admin_acu@gmail.com', 
			 'password' 		=> 'admin1234' ],
		]];

		// Insertar datos en la BD
	
        foreach($data['credentials'] as $user) 
        {
         	// Inserta los roles en la BD

         	DB::table('users')->insert(['identity_card' => $user['identity_card'], 
         								'first_name'    => $user['first_name'],
         								'last_name'     => $user['last_name'],
         								'phone_number'  => $user['phone_number'],
         								'email'         => $user['email'],
         								'password'      => \Hash::make($user['password'])]);
        }

        /* Predefinimos los permisos para cada usuario */

        // Usuario Administrador

        $user = User::where('first_name','admin')->first();
        $role = Role::where('name','admin')->first();

        $user->attachRole($role);
        $user->save();

    }
}
