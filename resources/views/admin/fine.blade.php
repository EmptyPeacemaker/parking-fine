@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">@if($user){{$user->name}}@else Все штрафы @endif</div>
            <div class="card-body">
                @if($user)
                    @if($user->getCar)
                        Автомобили:
                        <div class="row">
                            <div class="col-auto p-1">
                                <a class="btn btn-outline-primary"
                                   href="{{route('admin.fine',['id'=>$user->id])}}">Все</a>
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
                            <div class="col-auto btn btn-success" data-bs-toggle="modal" data-bs-target="#fine">Добавить
                                штраф
                            </div>
                        @endif
                    </div>
                @endif
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Номер машины</th>
                        <th scope="col">Штраф</th>
                        <th scope="col">Стоимость</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Адрес</th>
                        @if($user)<th scope="col"></th>@endif
                    </tr>
                    </thead>
                    <tbody>
                    <?php $number = null;?>
                    @forelse($fines as $fine)
                        <tr>
                            <th scope="row">{{$fine->id}}</th>
                            @if($number!=$fine->getCar->id)
                                <td style="border-top: 2px solid black; border-left: 1px solid black">
                                    <?php $number = $fine->getCar->id;?>
                                    {{$fine->getCar->number}}
                                </td>
                            @else
                                <td style="border-left: 1px solid black"></td>
                            @endif

                            <td>{{$fine->text}}</td>
                            <td>{{$fine->price}}</td>
                            <td>{{$fine->created_at->format('H:i d/m/Y')}}</td>
                            <td>{{$fine->adr}}</td>
                            @if($user)
                                <td>
                                    <div class="d-flex flex-row">
                                    <span data-bs-toggle="modal" data-bs-target="#fine"
                                          data-id="{{$fine->id}}" data-text="{{$fine->text}}"
                                          data-car_id="{{$fine->getCar->id}}"
                                          data-price="{{$fine->price}}" data-adr="{{$fine->adr}}"
                                          class="material-icons btn-success btn m-1 edit">edit</span>
                                        <a href="{{route('admin.fine-delete',['id'=>$fine->id])}}"
                                           class="material-icons btn-danger btn m-1">delete</a>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Автомобили не добавлены</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if(!$user)
                <div class="d-flex m-1">
                    <a class=" btn btn-success" href="{{route('admin.download')}}">Скачать отчет</a>
                </div>
            @endif
            <div class="card-footer d-flex justify-content-center">{{$fines->onEachSide(1)->links()}}</div>
        </div>
    </div>
    @if($user)
        <div class="modal fade" id="fine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form class="modal-dialog" method="post" action="{{route('admin.fine')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Оформление штрафа</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select class="form-select mb-2" name="car_id" required>
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
                        <select class="form-select mb-2" name="adr" required>
                            @foreach(['ул. Большая Шерстомойная, 40 корпус 1','ул. Адмирала Макарова, 5'] as $adr)
                                <option value="{{$adr}}">{{$adr}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Оформить</button>
                    </div>
                </div>
            </form>
        </div>
        <script>
            $('.edit').on('click', function (event) {
                $('.modal-dialog').attr('action', '{{route('admin.fine')}}/' + $(this).data('id') + '/' + $(this).data('car_id'))
                $('[name=car_id]').val($(this).data('car_id')).prop("disabled", true)
                $('[name=text]').html($(this).data('text'))
                $('[name=price]').val($(this).data('price'))
                $('[name=adr]').val($(this).data('adr'))
            })

            $('.modal').on('hidden.bs.modal', function () {
                $('.modal-dialog').attr('action', '{{route('admin.fine')}}')
                $('[name=car_id]').prop("disabled", false)
                $('[name=text]').html('')
                $('[name=price]').val(0)
            })
        </script>
    @endif
@endsection
