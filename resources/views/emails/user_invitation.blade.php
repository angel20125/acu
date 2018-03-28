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

			    <p>Le notificamos que el presidente del <b>{{$council->name}}</b>, ha convocado una reunión para el día <b>{{DateTime::createFromFormat("Y-m-d",$diary->event_date)->format("d/m/Y")}}</b>, que se llevará a cabo en <b>{{$diary->place}}</b>, donde se tratará una nueva agenda con respecto a la siguiente temática:</p>

			    <p style="font-style:oblique;"><b>"{{$diary->description}}"</b></p>

			    <p>Lo invitamos a participar en la creación y organización de la nueva agenda, proponiendo todos los puntos que usted desee. Para ello, debe dirigirse a nuestra plataforma haciendo <a href="{{route("home")}}">clic aquí.</a></p>

				<div style="width: 100%; background: #007bff; padding: 10px; box-sizing: border-box; color: #fff; text-align: center">ACU Team</div>
			</div>
			<div style="margin-bottom: 25px; height: 7px; width: 100%; background: #007bff"></div>
		</div>
	</body>
</html>