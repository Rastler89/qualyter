@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@endsection

@section('content')

<table class="table table-hover table-striped">
    <thead>
        <th scope="col">{{__('Store')}}</th>
        <th scope="col">{{__('Status')}}</th>
        <th scope="col">{{__('Impact')}}</th>
        <th scope="col">{{__('Responsable')}}</th>
        <th scope="col">{{__('Agent')}}</th>
        <th scope="col">{{__('Closing day')}}</th>
        <th scope="col"></th>
    </thead>
    <tbody>
        @foreach($incidences as $incidence)
            @switch($incidence->status)
                @case(0) <tr class="table-danger"> @break
                @case(1) <tr class="table-warning"> @break
            @endswitch
                <td>
                    @foreach($stores as $store)
                    @if($store->code == $incidence->store)
                        {{$store->name}}
                    @endif
                    @endforeach
                </td>
                <td>
                    @switch($incidence->status)
                        @case(0)
                            {{__('Open')}}
                            @break
                        @case(1)
                            {{__('Pending reply')}}
                            @break
                        @case(2)
                            {{__('In process')}}
                            @break
                        @case(3)
                            {{__('Refused')}}
                            @break
                        @case(4)
                            {{__('Complete')}}
                            @break
                    @endswitch
                </td>
                <td>
                    @switch($incidence->impact)
                        @case(0)
                            <button type="button" class="btn btn-outline-danger">{{__('Urgent')}}</button>
                            @break
                        @case(1)
                            <button type="button" class="btn btn-outline-high">{{__('High')}}</button>
                            @break
                        @case(2)
                            <button type="button" class="btn btn-outline-warning">{{__('Medium')}}</button>
                            @break
                        @case(3)
                            <button type="button" class="btn btn-outline-success">{{__('Low')}}</button>
                            @break
                    @endswitch
                </td>
                <td>
                    @foreach($users as $user)
                    @if($user->id == $incidence->responsable)
                    {{$user->name}}
                    @endif
                    @endforeach
                </td>
                <td>
                    @foreach($agents as $agent)
                    @if($agent->id == $incidence->owner)
                    {{$agent->name}}
                    @endif
                    @endforeach
                </td>
                <td>
                    {{$incidence->closed}}
                </td>
                <td>
                    <a href="{{route('incidences.view',['id' => $incidence->id])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="eye"></i></a>
                    <a href="{{route('incidences.resend',['id' => $incidence->id])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="send"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection