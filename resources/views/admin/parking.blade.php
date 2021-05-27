@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">Машины на стоянке</div>
                    <div class="col-auto btn-success btn" data-bs-toggle="modal" data-bs-target="#addparking">Добавить машину</div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Номер машины</th>
                        <th scope="col">Время начала стоянки</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cars as $car)
                        <?php
                        $start = $car->getParking->create->addHours(5);
                        $time=$start->format('H:i d/m/Y');
                        $price=$start->diffInHours(now())*25;
                        ?>
                        <tr>
                            <th scope="row">{{$car->id}}</th>
                            <th>{{$car->number}}</th>
                            <th>{{$time}}</th>
                            <th>{{$price}}</th>
                            <th><a href="{{route('admin.parking',['id'=>$car->getParking->id])}}"
                                   class="material-icons btn-danger btn m-1">delete</a></th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Автомобили не добавлены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-center">{{$cars->onEachSide(1)->links()}}</div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addparking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" aria-label="{{route('admin.parking')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление машины</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select mb-2" name="car_id" required>
                        @foreach($all as $car)
                            <option value="{{$car->id}}">{{$car->number}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
