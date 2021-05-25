<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>

</head>
<body>

<div class="row justify-content-end m-2 fixed-top">
    <div class="col-auto row">
        @auth
            <div class="col-auto"><a href="{{ url('/home') }}" class="btn btn-outline-dark ml-1 mr-1">Личный кабинет</a></div>
            <div class="col-auto"><a href="{{ route('logout') }}" class="btn btn-outline-dark ml-1 mr-1">Выход</a></div>
        @else
            <div class="col-auto"><a href="{{ url('/login') }}" class="btn btn-outline-dark ml-1 mr-1">Авторизация</a></div>
            <div class="col-auto"><a href="{{ url('/register') }}" class="btn btn-outline-dark ml-1 mr-1">Регистрация</a></div>
        @endauth
    </div>
</div>



@yield('content')

</body>
</html>
