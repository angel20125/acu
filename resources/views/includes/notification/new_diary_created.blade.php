<li>
    <a href="{{route('get_diary', [$notification->data['diary']['id']])}}">
        {{$notification->data['user']['first_name']}} creo la nueva agenda <strong>{{$notification->data['diary']['description']}}</strong> del
        consejo del que eres parte a las {{$notification->data['repliedTime']['date']}} .
    </a>
</li>
