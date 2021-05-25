@extends('layouts.app')
@section('content')
<div class="container">


    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Номер автомобиля</th>
            <th scope="col">Штраф</th>
            <th scope="col">Стоимость</th>
            <th scope="col">Дата оформления</th>
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
            <tr><td colspan="3" class="text-center">Штрафы не обнаружены</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
