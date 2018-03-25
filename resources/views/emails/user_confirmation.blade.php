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

			    <p>Le damos una cordial bienvenida a la Agenda de Consejos Unegista (ACU), por favor debe confirmar su email para poder iniciar sesión en nuestra plataforma.</p>
			    <p>Para ello, simplemente debe hacer clic en el siguiente enlace:</p>

			    <a href="{{url('/verify/'.$confirmation_code)}}">
			        Clic aquí para confirmar su email
			    </a>

			    <p>Una vez confirmada su cuenta, utilice la siguiente información para poder iniciar sesión por primera vez:</p>
				<p>Usuario: {{ $user->email }}</p>
				<p>Contraseña: 12345 (Cámbiala una vez ingreses) </p>

				<div style="width: 100%; background: #007bff; padding: 10px; box-sizing: border-box; color: #fff; text-align: center">ACU Team</div>
			</div>
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
		</div>
	</body>
</html>