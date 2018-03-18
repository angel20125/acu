<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<div style="border: 1px solid #eee; max-width: 600px; border-top: 0; border-bottom:0; margin: 0 auto">
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
			<div style="margin: 10px 10px; text-align: left; padding: 10px; color: #555">

				<div style="text-align: center;">
					<h1 style="color: #007bff">ACU</h1>
				</div>

				<p>Hola {{$user->first_name}},</p>

				<p>Le damos una cordial bienvenida a la Agenda de Consejos Unegistas (ACU), desde este momento ya puede ingresar a nuestra plataforma, su rol dentro de la misma será de <b>{{$rol->display_name}} del {{$council->name}}</b>.</p>

				<p>Para ingresar, diríjase al link que está al final del correo y utilice la siguiente información:</p>
				<p>Usuario: {{ $user->email }}</p>
				<p>Contraseña: 12345 (Cámbiala una vez ingreses) </p>

				<p><a href="{{route('home')}}">Ingrese aquí</a> para ir a la plataforma.</p>

				<div style="width: 100%; background: #007bff; padding: 10px; box-sizing: border-box; color: #fff; text-align: center">ACU Team</div>
			</div>
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
		</div>
	</body>
</html>