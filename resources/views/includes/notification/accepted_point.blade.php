
<a class="dropdown-item" href="{{route('get_point', [$notification->data['point']['id']])}}">
        {{$notification->data['user']['first_name']}} aceptó tu punto <strong>{{$notification->data['point']['description']}}</strong>.
</a>
