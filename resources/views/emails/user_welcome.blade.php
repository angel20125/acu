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

				<p>Hola {{$user->first_name}},</p>

				<p>Te damos una cordial bienvenida a la Agenda de Consejos Unegistas (ACU), desde este momento ya puedes ingresar a nuestra plataforma, tu rol dentro de la misma será de <b>{{$rol->display_name}} del {{$council->name}}</b>.</p>

				<p>Para ingresar, dirígete al link que está al final del correo y utiliza la siguiente información:</p>
				<p>Usuario: {{ $user->email }}</p>
				<p>Contraseña: 12345 (Cámbiala una vez ingreses) </p>

				<p><a href="{{route('home')}}">Ingresa aquí</a> para ir a la plataforma.</p>

				<div style="width: 100%; background: #007bff; padding: 10px; box-sizing: border-box; color: #fff; text-align: center">ACU Team</div>
			</div>
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
		</div>
	</body>
</html>