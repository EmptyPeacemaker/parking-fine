@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Номер автомобиля</th>
                <th scope="col">Время начала стоянки</th>
                <th scope="col">Стоимость</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cars as $car)
                <tr>
                    <?php
                    $start = $car->getParking->create->addHours(5);
                    $time = $start->format('H:i d/m/Y');
                    $price = $start->diffInHours(now()) * 25;
                    ?>
                    <th scope="row">{{$car->id}}</th>
                    <th>{{$car->number}}</th>
                    <th>{{$time}}</th>
                    <th>{{$price}}</th>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Машины не обнаружены</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
