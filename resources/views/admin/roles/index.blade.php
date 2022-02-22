@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('roles.new')}}">{{__('New Role')}}</a>
</div>
<table class=" table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Slug')}}</th>
            @can('edit-roles')
            <th scope="col"></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
        <tr>
            <td>{{$role->name}}</td>
            <td>{{$role->slug}}</td>
            @can('edit-roles')
            <td><a href="#" class="btn btn-warning">{{__('Edit Role')}}</a></td>
            @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@endsection