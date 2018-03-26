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
use App\Models\Position;
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
        //Position Secretary
        $secretary = new Position();
        $secretary->name = 'Secretary';
        $secretary->save();

        //Position Administrador
        $position = new Position();
        $position->name = 'Administrador';
        $position->save();

        $position = Position::where('name','Administrador')->first();

		$data = ['credentials' => [

			//Súper Admin
			['identity_card' 	=> 'admin',
			 'first_name' 		=> 'Administrador', 
			 'last_name' 		=> 'ACU', 
			 'phone_number' 	=> 'admin', 
			 'email' 			=> 'acu.uneg@gmail.com', 
			 'password' 		=> 'admin1234',
             'validate'         => 1,
             'position_id'      => $position->id],
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
                                        'password'      => \Hash::make($user['password']),
                                        'validate'      => $user['validate'],
                                        'position_id'   => $user['position_id']]);
        }

        /* Predefinimos los permisos para cada usuario */

        // Usuario Administrador
        $user = User::where('first_name','Administrador')->first();
        $role = Role::where('name','admin')->first();

        $user->attachRole($role);
        $user->save();

    }
}
