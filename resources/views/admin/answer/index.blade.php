@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-primary" href="{{route('users.new')}}">{{__('New Task')}}</a>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Store')}}</th>
            <th scope="col">{{__('Expiration')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
        @foreach($stores as $store)
        @if($store->code == $answer->store)
        @if($store->phonenumber==null && $store->email==null)
            <tr class="table-dark">
        @else
            @switch($answer->status)
                @case(0) <tr class="table-success"> @break
                @case(1) <tr class="table-warning"> @break
                @case(2) <tr class="table-warning"> @break
                @case(3) <tr class="table-danger"> @break
            @endswitch
        @endif
            <td>
                {{$store->name}}
            </td>
            <td>
                {{$answer->expiration}}
            </td>
            <td>
                @if($store->phonenumber!=null)
                    <a href="{{route('tasks.view',['id'=>$answer->id])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="phone"></i></a>
                @elseif($store->email!=null)
                    <a href="#" class="btn btn-outline-primary"><i class="align-middle" data-feather="send"></i></a>
                @else 
                    <a href="#" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
    </tbody>
</table>
@endsection