
<a class="dropdown-item dropdown-item-menu" href="{{route('get_point', [$notification->data['point']['id']])}}">
        {{$notification->data['user']['first_name']}} aceptó tu punto <strong>{{$notification->data['point']['description']}}</strong>.
</a>
