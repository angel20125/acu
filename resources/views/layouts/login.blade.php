<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title>@yield('title') - ACU</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    
    @yield('links')
</head>

<body>
<main  class="text-center col-md-6 col-lg-4 col-sm-6">
     @yield('content')
</main>
</body>
</html>