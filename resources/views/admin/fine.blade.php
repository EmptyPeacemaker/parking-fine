@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{$user->name}}</div>
            <div class="card-body">
                @if($user->getCar)
                    Автомобили:
                    <div class="row">
                        <div class="col-auto p-1">
                            <a class="btn btn-outline-primary" href="{{route('admin.fine',['id'=>$user->id])}}">Все</a>
                        </div>
                        @foreach($user->getCar as $car)
                            <div class="col-auto p-1">
                                <a class="btn btn-outline-primary"
                                   href="{{route('admin.fine',['id'=>$user->id,'number'=>$car->number])}}">{{$car->number}}</a>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">Штрафы:</div>
                    @if($user->getCar)
                    <div class="col-auto btn btn-success" data-bs-toggle="modal" data-bs-target="#fine">Добавить штраф</div>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Номер машины</th>
                        <th scope="col">Штраф</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col">Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $number=null;?>
                    @forelse($fines as $fine)
                        <tr>
                            <th scope="row">{{$fine->id}}</th>
                            <td>
                                @if($number!=$fine->getCar->id)
                                    <?php $number=$fine->getCar->id;?>
                                        {{$fine->getCar->number}}
                                @endif
                            </td>
                            <td>{{$fine->text}}</td>
                            <td>{{$fine->price}}</td>
                            <td>{{$fine->created_at->format('H:i d/m/Y')}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Автомобили не добавлены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{$fines->onEachSide(1)->links()}}</div>
        </div>
    </div>
    <div class="modal fade" id="fine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class="modal-dialog" method="post" action="{{route('admin.fine')}}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Оформление штрафа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select mb-2" name="car_id" aria-label="Default select example" required>
                        @foreach($user->getCar as $car)
                            <option value="{{$car->id}}">{{$car->number}}</option>
                        @endforeach
                    </select>
                    <div class="mb-3">
                        <label for="text" class="form-label">Текст штрафа</label>
                        <textarea class="form-control" id="text" name="text" required rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Стоимость</label>
                        <input type="number" name="price" min="0" class="form-control" required id="price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Оформить</button>
                </div>
            </div>
        </form>
    </div>

@endsection
