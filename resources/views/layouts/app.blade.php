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
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="container pt-2">
    <div class="row justify-content-between">
        <div class="col-auto">
            <a class="btn btn-outline-dark" href="{{ route('index') }}">Главная</a>
        </div>
        <div class="col-auto row">
            @auth
                <div class="btn-group col-auto">
                    <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{auth()->user()->name}}
                    </button>
                    <ul class="dropdown-menu">
                        @if(\App\Role::where('id',auth()->id())->where('role_id',1)->first())
                        <li><a class="dropdown-item" href="{{route('admin.index')}}">Панель администратора</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{route('add-car')}}">Мои автомобили</a></li>
                        <li><a class="dropdown-item" href="{{route('parking')}}">На штраф стоянке</a></li>
                        <li><a class="dropdown-item" href="{{route('home')}}">Штрафы</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Выход</a></li>
                    </ul>
                </div>
            @else
                <div class="col-auto"><a href="{{ url('/login') }}" class="btn btn-outline-dark ml-1 mr-1">Авторизация</a></div>
                <div class="col-auto"><a href="{{ url('/register') }}" class="btn btn-outline-dark ml-1 mr-1">Регистрация</a></div>
            @endauth
        </div>
    </div>

</div>

<div style="margin-top: 100px">
    @yield('content')
</div>

</body>
</html>
