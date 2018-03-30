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
use App\Models\Diary;
use App\Models\Point;
use App\Models\Council;
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
        //CARGOS

        //Position Administrador
        $admin = new Position();
        $admin->name = 'Administrador';
        $admin->save();

        //Position Secretary
        $secretary = new Position();
        $secretary->name = 'Secretary';
        $secretary->save();

        //Position Rector(a)
        $rector = new Position();
        $rector->name = 'Rector(a)';
        $rector->save();

        //Position Vicerrector(a) Académico
        $vicerrector_academico = new Position();
        $vicerrector_academico->name = 'Vicerrector(a) Académico';
        $vicerrector_academico->save();

        //Position Vicerrector(a) Administrativo
        $vicerrector_administrativo = new Position();
        $vicerrector_administrativo->name = 'Vicerrector(a) Administrativo';
        $vicerrector_administrativo->save();

        //Position Coordinador(a) General de Pregrado
        $coordinador_general_pregrado = new Position();
        $coordinador_general_pregrado->name = 'Coordinador(a) General de Pregrado';
        $coordinador_general_pregrado->save();

        //Position Coordinador(a) General de Investigación y Postgrado
        $coordinador_general_investigación= new Position();
        $coordinador_general_investigación->name = 'Coordinador(a) General de Investigación y Postgrado';
        $coordinador_general_investigación->save();

        //Position Representante Profesoral Principal
        $representante_profesoral_principal= new Position();
        $representante_profesoral_principal->name = 'Representante Profesoral Principal';
        $representante_profesoral_principal->save();

        //Position Representante Profesoral Principal de los Jubilados
        $representante_profesoral_principal_jubi= new Position();
        $representante_profesoral_principal_jubi->name = 'Representante Profesoral Principal de los Jubilados';
        $representante_profesoral_principal_jubi->save();

        //Position Representante Administrativo
        $representante_administrativo= new Position();
        $representante_administrativo->name = 'Representante Administrativo';
        $representante_administrativo->save();

        //Position Secretario(a) de Actas
        $secretario_actas= new Position();
        $secretario_actas->name = 'Secretario(a) de Actas';
        $secretario_actas->save();

        //Position Profesor(a)
        $profesor= new Position();
        $profesor->name = 'Profesor(a)';
        $profesor->save();




        //CONSEJOS

        //Council Consejo Universitario
        $universitario= new Council();
        $universitario->name = 'Consejo Universitario';
        $universitario->save();

        //Council Consejo Académico
        $academico= new Council();
        $academico->name = 'Consejo Académico';
        $academico->save();

        //Council Consejo Administrativo
        $administrativo= new Council();
        $administrativo->name = 'Consejo Administrativo';
        $administrativo->save();

        //Council Consejo Departamental
        $departamental= new Council();
        $departamental->name = 'Consejo Departamental';
        $departamental->save();

        //Council Consejo de Investigación y Postgrado
        $investigacion_post= new Council();
        $investigacion_post->name = 'Consejo de Investigación y Postgrado';
        $investigacion_post->save();

        $admin = Position::where('name','Administrador')->first();

		$data = ['credentials' => [

			//Súper Admin
			['identity_card' 	=> 'admin',
			 'first_name' 		=> 'Administrador', 
			 'last_name' 		=> 'ACU', 
			 'phone_number' 	=> 'admin', 
			 'email' 			=> 'acu.uneg@gmail.com', 
			 'password' 		=> 'admin1234',
             'validate'         => 1,
             'position_id'      => $admin->id],
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

        //Usuario Administrador
        $user = User::where('first_name','Administrador')->first();
        $admin = Role::where('name','admin')->first();

        $user->attachRole($admin);
        $user->save();





        //ROLES
        $presidente = Role::where('name','presidente')->first();
        $consejero = Role::where('name','consejero')->first();
        $secretaria = Role::where('name','secretaria')->first();
        $adjunto = Role::where('name','adjunto')->first();





        //USUARIOS

        //José
        $jose= new User();
        $jose->identity_card= '25040903';
        $jose->first_name= 'José';
        $jose->last_name= 'Avilés';
        $jose->phone_number= '04263997803';
        $jose->email= 'joseaviles230796@gmail.com';
        $jose->password= '12345';
        $jose->validate= 1;
        $jose->position_id= $rector->id;
        $jose->save();

        $jose->attachRole($presidente);
        $jose->councils()->attach($universitario->id,["role_id"=>$presidente->id]);
        Council::where("id",$universitario->id)->update(["president_id"=>$jose->id]);

        $jose->attachRole($adjunto);
        $jose->councils()->attach($academico->id,["role_id"=>$adjunto->id]);
        Council::where("id",$academico->id)->update(["adjunto_id"=>$jose->id]);

        //Cesar
        $cesar= new User();
        $cesar->identity_card= '26936086';
        $cesar->first_name= 'Cesar';
        $cesar->last_name= 'Medina';
        $cesar->phone_number= '04124983958';
        $cesar->email= 'cesardanielm21@gmail.com';
        $cesar->password= '12345';
        $cesar->validate= 1;
        $cesar->position_id= $coordinador_general_pregrado->id;
        $cesar->save();

        $cesar->attachRole($presidente);
        $cesar->councils()->attach($academico->id,["role_id"=>$presidente->id]);
        Council::where("id",$academico->id)->update(["president_id"=>$cesar->id]);

        $cesar->attachRole($adjunto);
        $cesar->councils()->attach($universitario->id,["role_id"=>$adjunto->id]);
        Council::where("id",$universitario->id)->update(["adjunto_id"=>$cesar->id]);

        //Victor
        $victor= new User();
        $victor->identity_card= '26073162';
        $victor->first_name= 'Victor';
        $victor->last_name= 'León';
        $victor->phone_number= '04265935833';
        $victor->email= 'vdleon30@gmail.com';
        $victor->password= '12345';
        $victor->validate= 1;
        $victor->position_id= $vicerrector_administrativo->id;
        $victor->save();

        $victor->attachRole($presidente);
        $victor->councils()->attach($administrativo->id,["role_id"=>$presidente->id]);
        Council::where("id",$administrativo->id)->update(["president_id"=>$victor->id]);

        $victor->attachRole($consejero);
        $victor->councils()->attach($universitario->id,["role_id"=>$consejero->id]);

        //Jessele
        $jessele= new User();
        $jessele->identity_card= '25696458';
        $jessele->first_name= 'Jessele';
        $jessele->last_name= 'Durán';
        $jessele->phone_number= '04249687063';
        $jessele->email= 'jesseleadt@gmail.com';
        $jessele->password= '12345';
        $jessele->validate= 1;
        $jessele->position_id= $profesor->id;
        $jessele->save();

        $jessele->attachRole($presidente);
        $jessele->councils()->attach($departamental->id,["role_id"=>$presidente->id]);
        Council::where("id",$departamental->id)->update(["president_id"=>$jessele->id]);

        $jessele->attachRole($adjunto);
        $jessele->councils()->attach($administrativo->id,["role_id"=>$adjunto->id]);
        Council::where("id",$administrativo->id)->update(["adjunto_id"=>$jessele->id]);

        //Leonardo
        $leonardo= new User();
        $leonardo->identity_card= '26691085';
        $leonardo->first_name= 'Leonardo';
        $leonardo->last_name= 'Hernández';
        $leonardo->phone_number= '04249383599';
        $leonardo->email= 'hernandezleonardo085@gmail.com';
        $leonardo->password= '12345';
        $leonardo->validate= 1;
        $leonardo->position_id= $profesor->id;
        $leonardo->save();

        $leonardo->attachRole($presidente);
        $leonardo->councils()->attach($investigacion_post->id,["role_id"=>$presidente->id]);
        Council::where("id",$investigacion_post->id)->update(["president_id"=>$leonardo->id]);

        $leonardo->attachRole($adjunto);
        $leonardo->councils()->attach($departamental->id,["role_id"=>$adjunto->id]);
        Council::where("id",$departamental->id)->update(["adjunto_id"=>$leonardo->id]);

        //Ángel
        $angel= new User();
        $angel->identity_card= '18078863';
        $angel->first_name= 'Ángel';
        $angel->last_name= 'Quintero';
        $angel->phone_number= '04249257854';
        $angel->email= 'angelq2009@gmail.com';
        $angel->password= '12345';
        $angel->validate= 1;
        $angel->position_id= $representante_profesoral_principal->id;
        $angel->save();

        $angel->attachRole($consejero);
        $angel->councils()->attach($universitario->id,["role_id"=>$consejero->id]);

        $angel->attachRole($adjunto);
        $angel->councils()->attach($investigacion_post->id,["role_id"=>$adjunto->id]);
        Council::where("id",$investigacion_post->id)->update(["adjunto_id"=>$angel->id]);

        //Gerardo
        $gerardo= new User();
        $gerardo->identity_card= '20808633';
        $gerardo->first_name= 'Gerardo';
        $gerardo->last_name= 'González';
        $gerardo->phone_number= '04128620192';
        $gerardo->email= 'gergmdoc@gmail.com';
        $gerardo->password= '12345';
        $gerardo->validate= 1;
        $gerardo->position_id= $profesor->id;
        $gerardo->save();

        $gerardo->attachRole($consejero);
        $gerardo->councils()->attach($universitario->id,["role_id"=>$consejero->id]);




        //AGENDAS

        $diary_1=Diary::create(
        [
            "council_id"=>$universitario->id,
            "description"=>"Solicitudes variadas que conciernen al Consejo",
            "place"=>"UNEG - Chilemex",
            "event_date"=>"2018-03-15",
            "limit_date"=>"2018-03-14"
        ]);

        Point::create(
        [
          'user_id' => $jose->id,
          'diary_id' => $diary_1->id,
          'title' => "punto_1",
          'description' => "Solicitud para derogar la Resolución CD/CU-11-057 de fecha 06-11-2018, referida a la firma del Convenio Cooperación Institucional entra la empresa Nacional Forestal, S.A. y la UNEG.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-09"
        ]);

        Point::create(
        [
          'user_id' => $gerardo->id,
          'diary_id' => $diary_1->id,
          'title' => "punto_2",
          'description' => "Solicitud de modificación de la Resolución CU-O-04-032 de fecha 09-03-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-10"
        ]);

        Point::create(
        [
          'user_id' => $victor->id,
          'diary_id' => $diary_1->id,
          'title' => "punto_3",
          'description' => "Solicitud del uso del logo de la UNEG en el Congreso La Fuerza del Petróleo.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-11"
        ]);

        Point::create(
        [
          'user_id' => $cesar->id,
          'diary_id' => $diary_1->id,
          'title' => "punto_4",
          'description' => "Solicitud de modificación de la Resolución CU-O-12-755 de fecha 21-02-2018, referida al cambio de fecha de la jubilación de la ciudadana Mariela Josefina Quiñones Calderón.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-12"
        ]);

        Point::create(
        [
          'user_id' => $angel->id,
          'diary_id' => $diary_1->id,
          'title' => "punto_5",
          'description' => "Solicitud de aprobación del SASMA 2018, para los servicios de hospitalización, cirugía y maternidad del personal administrativo y obrero de la UNEG.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-13"
        ]);

        $diary_2=Diary::create(
        [
            "council_id"=>$administrativo->id,
            "description"=>"Solicitudes de jubilación",
            "place"=>"UNEG - Atlántico",
            "event_date"=>"2018-03-07",
            "limit_date"=>"2018-03-06"
        ]);

        Point::create(
        [
          'user_id' => $victor->id,
          'diary_id' => $diary_2->id,
          'title' => "punto_1",
          'description' => "Solicitud de jubilación del ciudadano Yoel José Velásquez Salazar C.I. No. 8.954.612., a partir del 01-05-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-06"
        ]);

        Point::create(
        [
          'user_id' => $victor->id,
          'diary_id' => $diary_2->id,
          'title' => "punto_2",
          'description' => "Solicitud de jubilación por edad del profesor Héctor Efrén Henríquez Angarita C.I. No. 4.130.903., a partir del 01-05-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-05"
        ]);

        Point::create(
        [
          'user_id' => $victor->id,
          'diary_id' => $diary_2->id,
          'title' => "punto_3",
          'description' => "Solicitud de contratación del ciudadano Jorge Luis Monagas Oliveros C.I. No. 19.095.522., para desempeñar el cargo de Jefe de Protocolo en la Dirección de Relaciones Públicas, a partir del 15-03-2018 hasta el 30-06-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-04"
        ]);

        $diary_3=Diary::create(
        [
            "council_id"=>$academico->id,
            "description"=>"Solicitudes de remuneraciones y permisos",
            "place"=>"UNEG - Atlántico",
            "event_date"=>"2018-03-25",
            "limit_date"=>"2018-03-24"
        ]);

        Point::create(
        [
          'user_id' => $jose->id,
          'diary_id' => $diary_3->id,
          'title' => "punto_1",
          'description' => "Solicitud de renovación de beca sueldo de la profesora Militza Rodríguez C.I. No. 8.040.129., a partir del 01-05-2018 hasta el 31-12-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-23"
        ]);

        Point::create(
        [
          'user_id' => $jose->id,
          'diary_id' => $diary_3->id,
          'title' => "punto_2",
          'description' => "Solicitud de permiso remunerado del profesor Wilfredo Guaita, para asistir en calidad de co-director a la presentación de la tésis de la Profa. Ingrid de Naime en la Universidad Politécnica de Madrid – España, desde el 04-06-2018 hasta el 13-06-2018.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-22"
        ]);

        Point::create(
        [
          'user_id' => $jose->id,
          'diary_id' => $diary_3->id,
          'title' => "punto_3",
          'description' => "Solicitud de cambio de dedicación de los docentes a tiempo convencional, siete (7) horas semanales.",
          'type' => "decision",
          'pre_status' => "incluido",
          'created_at' => "2018-03-21"
        ]);
    }
}
