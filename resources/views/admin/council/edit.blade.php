@if($errors->any())
	@foreach ($errors->all() as $error)
        {{$error}}
	@endforeach
@endif

@if(session('message_info'))
    {{session('message_info')}}
@endif

<form action="{{route("admin_councils_update")}}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="council_id" value="{{$council->id}}"/>
	<input type="text" name="name" value="{{$council->name}}">
	<button class="btn btn-primary">Guardar</button>
</form>