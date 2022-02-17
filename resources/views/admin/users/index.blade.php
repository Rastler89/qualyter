@extends('layouts.dashboard')

@section('content')
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{$user->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection