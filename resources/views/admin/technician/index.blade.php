@extends('layouts.dashboard')
<?php 
    foreach($technicians as &$technician) {
        $array = json_decode($technician->services,true);
        foreach($array as $key => $value) {
            if(gettype($value)=='array') {
                $array[$key]=$value['other'];
            }
        }
        $technician->services = $array;
    }
?>
@section('content')
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">{{__('Company name')}}</th>
            <th scope="col">{{__('Contact')}}</th>
            <th scope="col">{{__('Services')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($technicians as $technician) 
        <tr>
            <td>{{$technician->company}}</td>
            <td>{{$technician->contact}}</td>
            <td>
                @foreach($technician->services as $service)
                    <span class="mr-2">{{$service}}</span>
                @endforeach
            </td>
            <td>
                <a href="{{route('technician.view',['id'=>$technician->id])}}" class="btn btn-outline-info"><i class="align-middle" data-feather="eye"></i></a>
                <a href="{{route('technician.download',['id'=>$technician->id])}}" class="btn btn-outline-success"><i class="align-middle" data-feather="download"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection