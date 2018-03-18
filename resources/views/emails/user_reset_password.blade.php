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

				<p>Está recibiendo esta notificación debido a que usted (o alguien pretendiendo ser usted) ha solicitado una recuperación de contraseña de ACU. Si usted no realizó esta petición, por favor ignore este correo. Si continúa recibiéndolo por favor contáctenos.</p>

				<p>Por favor ingrese al siguiente enlace para recuperar su contraseña: <a href="{{$resetLink}}">Clic aquí</a></p>

				<div style="width: 100%; background: #007bff; padding: 10px; box-sizing: border-box; color: #fff; text-align: center">ACU Team</div>
			</div>
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
		</div>
	</body>
</html>