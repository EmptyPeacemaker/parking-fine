@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Email</th>
                <th scope="col">Номера машины</th>
                <th scope="col">Дата регистрации</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <?php $view = false;?>
                <tr>
                    <th scope="row"><a href="{{route('admin.fine',['id'=>$user->id])}}" class="btn btn-outline-primary">{{$user->id}}</a></th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div class="row">
                            @forelse ($user->getCar as $car)
                                @if($loop->iteration<5)
                                    <a href="{{route('admin.fine',['id'=>$user->id,'number'=>$car->number])}}" class="col-auto m-1 btn btn-outline-primary">{{$car->number}}</a>
                                @else
                                    @if(!$view)
                                        <?php $view = true;?>
                                        <a href="{{route('admin.fine',['id'=>$user->id])}}" class="col-auto m-1 btn btn-outline-primary">Все автомобили...</a>
                                    @endif
                                @endif
                            @empty
                                <small class="alert-danger text-center">Автомобили не добавлены</small>
                            @endforelse
                        </div>

                    </td>
                    <td>{{$user->created_at->format('H:i d/m/Y')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$users->onEachSide(1)->links()}}
    </div>

@endsection
