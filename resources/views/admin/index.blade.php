@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <div class="ml-1 mr-1 card text-white bg-success mb-3 pb-1" style="width: 280px;height: 190px;">
                    <div class="card-header text-center">Количество орденов</div>
                    <div class="card-body">
                        <div class="row justify-content-around align-items-center">
                            <h1 class="col-auto">{{$orders}}</h1>
                            <span class="col-auto d-flex align-items-center material-icons" style="font-size: 60px">bar_chart</span>
                        </div>
                    </div>
                    <a href="{{route('admin.fine')}}" class="card-footer btn btn-success d-flex justify-content-center">Открыть <span
                            class="material-icons">chevron_right</span></a>
                </div>
            </div>
            <div class="col-auto">
                <div class="ml-1 mr-1 card text-white bg-warning mb-3 pb-1" style="width: 280px;height: 190px;">
                    <div class="card-header text-center">Всего пользователей</div>
                    <div class="card-body">
                        <div class="row justify-content-around align-items-center">
                            <h1 class="col-auto">{{$users}}</h1>
                            <span class="col-auto d-flex align-items-center material-icons" style="font-size: 60px">person_add</span>
                        </div>
                    </div>
                    <a href="{{route('admin.users')}}" class="card-footer btn btn-warning d-flex justify-content-center">Открыть <span
                            class="material-icons">chevron_right</span></a>
                </div>
            </div>
            <div class="col-auto">
                <div class="ml-1 mr-1 card text-white bg-primary mb-3 pb-1" style="width: 280px;height: 190px;">
                    <div class="card-header text-center">Машин на стоянке</div>
                    <div class="card-body">
                        <div class="row justify-content-around align-items-center">
                            <h1 class="col-auto">{{$cars}}</h1>
                            <span class="col-auto d-flex align-items-center material-icons" style="font-size: 60px">local_shipping</span>
                        </div>
                    </div>
                    <a href="{{route('admin.parking')}}" class="card-footer btn btn-primary d-flex justify-content-center">Открыть <span
                            class="material-icons">chevron_right</span></a>
                </div>
            </div>
        </div>
    </div>

@endsection
