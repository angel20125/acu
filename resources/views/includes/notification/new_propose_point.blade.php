@if($user->councils()->wherePivot("role_id",$user->getCurrentRol()->id)->first()->id==$notification->data['point']['diary']['council']['id'])
	<a class="dropdown-item dropdown-item-menu" href="{{route('get_presidente_points')}}">
	    <b>{{$notification->data['user']['first_name']}}</b> presentó un nuevo punto.
	</a>
@else
	<a class="dropdown-item dropdown-item-menu" href="{{route('get_presidente_points')}}">
	    <b>{{$notification->data['user']['first_name']}}</b> presentó un nuevo punto. Para evaluarlo debes ir a tu sesión de <b>Presidente</b>.
	</a>
@endif
