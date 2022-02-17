@extends('layouts.dashboard')

@section('content')
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Status')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>
                @can('edit-users')
                    hola
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection