@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-primary" href="{{route('stores.new')}}">{{__('Add Store')}}</a>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Code')}}</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Phone Number')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <?php $code = str_replace('/','_',$store->code); ?>
        <tr>
            <td>{{$store->code}}</td>
            <td>{{$store->name}}</td>
            <td>{{$store->phonenumber}}</td>
            <td>{{$store->email}}</td>
            <td><a href="{{route('stores.edit',['id'=>$code])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection