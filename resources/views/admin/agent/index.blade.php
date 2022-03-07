@extends('layouts.dashboard')

@section('content')
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form>
                <td>
                    <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}"/>
                </td>
                <td>
                    <input type="email" class="form-control" name="email" placeholder="{{__('E-mail')}}"/>
                </td>
                <td>
                    <button class="btn btn-success">{{__('Add new agent')}}</button>
                </td>
            </form>
        </tr>
        
    </tbody>
</table>
@endsection