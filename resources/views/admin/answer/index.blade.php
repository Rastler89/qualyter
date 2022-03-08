@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('users.new')}}">{{__('New Task')}}</a>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Status')}}</th>
            <th scope="col">{{__('Store')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
        @foreach($stores as $store)
        @if($store->code == $answer->store)
        <tr>
            <td><button 
                @switch($answer->status)
                    @case(0) class="btn btn-success disabled"> {{__('Open')}} @break
                    @case(1) class="btn btn-warning disabled"> {{__('In process')}} @break
                    @case(2) class="btn btn-warning disabled"> {{__('Sended')}} @break
                    @case(3) class="btn btn-danger disabled"> {{__('Pending Review')}} @break
                @endswitch
                </button>
            </td>
            <td>
                {{$store->name}}
            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
    </tbody>
</table>
@endsection