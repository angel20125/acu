<a style="background:#e8f5e9;" class="dropdown-item dropdown-item-menu" href="{{route('get_diary', [$notification->data['diary']['id']])}}">
	<b>{{$notification->data['user']['first_name']}}</b> ha registrado una nueva agenda del <b>{{$notification->data['diary']['council']['name']}}</b> para el día {{DateTime::createFromFormat("Y-m-d",$notification->data['diary']['event_date'])->format("d/m/Y")}}. <small>{{DateTime::createFromFormat("Y-m-d H:i:s",$notification->created_at)->format("d/m/Y h:ia")}}</small>
</a>
