@if($user->councils()->wherePivot("role_id",$user->getCurrentRol()->id)->first()->id==$notification->data['point']['diary']['council']['id'])
	<a style="background:#e8eaf6;" class="dropdown-item dropdown-item-menu" href="{{route('get_presidente_points')}}">
	    <b>{{$notification->data['user']['first_name']}}</b> presentó un nuevo punto: <p style="font-style: oblique;"><b>"{{substr($notification->data['point']['description'], 0, 20)."..."}}"</b></p> <small>{{DateTime::createFromFormat("Y-m-d H:i:s",$notification->created_at)->format("d/m/Y h:ia")}}</small>
	</a>
@else
	<a style="background:#e8eaf6;" class="dropdown-item dropdown-item-menu" href="{{route("change_rol",["rol_name"=>"presidente"])}}">
	    <b>{{$notification->data['user']['first_name']}}</b> presentó un nuevo punto. Para evaluarlo debes ir a tu sesión de <b>Presidente</b>. <small>{{DateTime::createFromFormat("Y-m-d H:i:s",$notification->created_at)->format("d/m/Y h:ia")}}</small>
	</a>
@endif
