@extends('layouts.index')
@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center mb-3"
         style="background-color: #e9ecef;height: 35vh;">
        <div style="font-size: 3.5em; font-weight: 300;">Недорогой вызов эвакуатора</div>
        <div style="font-size: 1.125rem; font-weight: 300;">ЭВАКУАЦИЯ В УФЕ ОТ 1000 РУБЛЕЙ</div>
        <hr class="w-75">
        <div></div>
        <a class="btn btn-warning btn-lg" href="tel: +79346489535" role="button">ВЫЗВАТЬ ЭВАКУАТОР</a>
    </div>
    <div class="container">
        <div class="row justify-content-around mb-3">
            @foreach($cards as $card)
                <div class="col-auto card" style="width: 300px;">
                    <img class="card-img-top" src="{{$card->img}}" alt="Card image cap" style="padding: 5em;">
                    <div class="card-body row align-items-center flex-column">
                        <div class="col-auto card-title text-center" style="width: 250px;font-weight: 500">{{$card->text}}</div>
                        <div class="col-auto">
                            <a href="tel: {{$card->tel}}" class="btn btn-warning">от {{$card->price}} руб</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
