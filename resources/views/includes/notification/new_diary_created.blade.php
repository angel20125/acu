<a class="dropdown-item dropdown-item-menu" href="{{route('get_diary', [$notification->data['diary']['id']])}}">
	<b>{{$notification->data['user']['first_name']}}</b> ha registrado una nueva agenda del <b>{{$notification->data['diary']['council']['name']}}.</b> 
</a>
