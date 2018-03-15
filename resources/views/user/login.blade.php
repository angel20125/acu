<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <form action="{{route("post_login")}}" method="post">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
        @csrf
        <input name="email" type="text" placeholder="Email"/>
        <input name="password" type="password" placeholder="Password"/>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>