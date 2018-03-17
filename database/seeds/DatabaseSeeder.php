<?php

/**
 *  @package        ACU.Database.Seeds.Database
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
 * Incluye la implementación de los siguientes Servicios 
 */


use Illuminate\Database\Seeder;


/**
 *  Seeder Base de Datos
 */

class DatabaseSeeder extends Seeder
{
    /**
     * Función que ejecuta cada uno de los Seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(CredentialsSeeder::class);
    }
}
