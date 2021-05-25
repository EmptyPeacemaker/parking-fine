@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-auto toast m-1" style="opacity: 1" action="{{route('add-car')}}" method="post">
                @csrf
                <label for="number" class="toast-header"><strong
                        class="me-auto">Новый автомобиль</strong>
                </label>
                <div class="toast-body row">
                    <div class="col-auto"><input type="text" name="number" required class="mb-2 form-control" id="number"></div>
                    <button type="submit" class="btn btn-outline-primary col-auto">Добавить</button>
                </div>
            </form>
            @foreach($cars as $car)
                <div class="col-auto toast m-1" style="opacity: 1">
                    <div class="toast-header"><strong
                            class="me-auto">Автомобиль</strong><small>{{$car->create->format('H:i d/m/Y')}}</small>
                    </div>
                    <div class="toast-body">{{$car->number}}</div>
                </div>
            @endforeach
        </div>
        <div>
            {{$cars->onEachSide(1)->links()}}
        </div>
    </div>
@endsection
