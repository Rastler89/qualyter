@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('clients.new')}}">{{__('Add Client')}}</a>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Delegation')}}</th>
            <th scope="col">{{__('Phone Number')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col">{{__('Language')}}</th>
            <th scoep="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client) 
        <tr>
            <td>{{$client->name}}</td>
            <td>{{$client->delegation}}</td>
            <td>{{$client->phonenumber}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->language}}</td>
            <td><a href="{{route('clients.edit',['id'=>$client->id])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection