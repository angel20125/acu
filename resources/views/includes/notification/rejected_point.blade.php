<a style="background:#fff3e0;" class="dropdown-item dropdown-item-menu" href="{{route('get_point', [$notification->data['point']['id']])}}">
    El presidente <b>{{$notification->data['user']['first_name']}}</b> desglosó tu punto: <p style="font-style: oblique;"><b>"{{substr($notification->data['point']['description'], 0, 20)."..."}}"</b></p> <small>{{DateTime::createFromFormat("Y-m-d H:i:s",$notification->created_at)->format("d/m/Y h:ia")}}</small>
</a>
