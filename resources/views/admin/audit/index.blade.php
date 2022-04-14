@extends('layouts.dashboard')

@section('content')

<table class="table table-hover table-striped" style="width:90%">
    <thead>
        <th scope="col">ID</th>
        <th scope="col">Action</th>
        <th scope="col">Type</th>
        <th scope="col">ID model</th>
        <th scope="col">User</th>
        <th scope="col">Old</th>
        <th scope="col">New</th>
        <th scope="col"></th>

    </thead>
    <tbody>
        @foreach($audit as $aud)
        <tr>
            <td>{{$aud->id}}</td>
            <td>{{$aud->event}}</td>
            <td>{{$aud->auditable_type}}</td>
            <td>{{$aud->auditable_id}}</td>
            <td>{{$aud->user_id}}</td>
            <td>{{\Illuminate\Support\Str::limit($aud->old_values, 50, $end='...')}}</td>
            <td>{{\Illuminate\Support\Str::limit($aud->new_values, 50, $end='...')}}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection