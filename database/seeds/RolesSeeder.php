<?php

/**
 *  @package        ACU.Database.Seeds.RolesSeeder
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

/**
 *  Seeder Roles
 */

class RolesSeeder extends Seeder
{
    /**
     * Función que almacena los roles predeterminados del sistema en la BD.
     *
     * @return void
     */
    public function run()
    {
		$data = ['roles' => [

			// Admin
			['name' 		=> 'admin',
			 'display_name' => 'Admin' ],

			// Presidente
			['name' 		=> 'presidente',
			 'display_name' => 'Presidente' ],

			// Consejero
			['name' 		=> 'consejero',
			 'display_name' => 'Consejero' ],

			// Adjunto
			['name' 		=> 'adjunto',
			 'display_name' => 'Adjunto' ],
		]];

		// Insertar datos en la BD
	
        foreach($data['roles'] as $roles) 
        {
         	// Inserta los roles en la BD

         	DB::table('roles')->insert(['name' => $roles['name'], 'display_name' => $roles['display_name']]);
        }

    }
}
