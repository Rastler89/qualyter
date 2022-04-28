@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@endsection

@section('content')
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                {{__('Filters')}}
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form class="form-inline" method="GET">
                    <div class="mb-3">
                        <label for="store" class="form-label">{{__('Store`s Name')}}</label>
                        <input type="text" class="form-control" name="store" placeholder="{{__('Store`s Name')}}"/>
                    </div>
                    <div class="mb-3">
                        <label for="client" class="form-label">{{__('Client`s Name')}}</label>
                        <input type="text" class="form-control" name="client" placeholder="{{__('Client`s Name')}}"/>
                    </div>
                    <button class="btn btn-danger">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-hover table-striped">
    <thead>
        <th scope="col">@sortablelink('store',__('Store'))</th>
        <th scope="col">@sortablelink('status',__('Status'))</th>
        <th scope="col">@sortablelink('impact',__('Impact'))</th>
        <th scope="col">@sortablelink('responsable',__('Responsable'))</th>
        <th scope="col">@sortablelink('owner',__('Agent'))</th>
        <th scope="col">@sortablelink('closed',__('Closing day'))</th>
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
{{$incidences->links()}}
@endsection