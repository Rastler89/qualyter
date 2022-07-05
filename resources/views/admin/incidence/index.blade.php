@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@endsection

@section('content')
<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filters"><i class="align-middle" data-feather="filter"></i></button>
  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#create"><i class="align-middle" data-feather="plus"></i></button>
</div>

<!-- Start filter -->
<form method="GET">
<div class="modal fade" id="filters" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterLabel">{{__("Filters")}}</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="store" class="form-label">{{__('Store`s Name')}}</label>
                                <input type="text" class="form-control" name="store" placeholder="{{__('Store`s Name')}}" @if(!empty($filters) && isset($filters['store'])) value="{{$filters['store']}}" @endif/>
                            </div>
                            <div class="mb-3">
                                <label for="client" class="form-label">{{__('Client`s Name')}}</label>
                                <input type="text" class="form-control" name="client" placeholder="{{__('Client`s Name')}}" @if(!empty($filters) && isset($filters['client'])) value="{{$filters['client']}}" @endif/>
                            </div>
                            <div class="mb-3">
                                <label for="agent" class="form-label">{{__('Agent')}}</label>
                                <input class="form-control" list="agents" id="agent" name="agent" placeholder="{{__('Type to search...')}}" @if(!empty($filters) && isset($filters['agent'])) value="{{$filters['agent']}}" @endif/>
                                <datalist id="agents">
                                    @foreach($agents as $agent)  
                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="responsable" class="form-label">{{__('Responsable')}}</label>
                                <input class="form-control" list="responsables" id="responsable" name="responsable" placeholder="{{__('Type to search...')}}" @if(!empty($filters) && isset($filters['responsable'])) value="{{$filters['responsable']}}" @endif/>
                                <datalist id="responsables">
                                    @foreach($users as $responsable)  
                                        <option value="{{$responsable->id}}">{{$responsable->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <label>{{__('Created')}}:</label>
                        <div class="input-group mb-3">
                            <input type="date" name="start_date_created" class="form-control" aria-label="{{__('Start date')}}" @if(!empty($filters) && isset($filters['start_date_created'])) value="{{$filters['start_date_created']}}" @endif>
                            <span class="input-group-text"><-></span>
                            <input type="date" name="end_date_created" class="form-control" aria-label="{{__('End date')}}" @if(!empty($filters) && isset($filters['end_date_created'])) value="{{$filters['end_date_created']}}" @endif>
                        </div>
                        <label>{{__('Closed day')}}:</label>
                        <div class="input-group mb-3">
                            <input type="date" name="start_date_closed" class="form-control" aria-label="{{__('Start date')}}" @if(!empty($filters) && isset($filters['start_date_closed'])) value="{{$filters['start_date_closed']}}" @endif>
                            <span class="input-group-text"><-></span>
                            <input type="date" name="end_date_closed" class="form-control" aria-label="{{__('End date')}}" @if(!empty($filters) && isset($filters['end_date_closed'])) value="{{$filters['end_date_closed']}}" @endif>
                        </div>
                        <label>{{__('Closing day')}}:</label>
                        <div class="input-group mb-3">
                            <input type="date" name="start_date_closing" class="form-control" aria-label="{{__('Start date')}}" @if(!empty($filters) && isset($filters['start_date_closing'])) value="{{$filters['start_date_closing']}}" @endif>
                            <span class="input-group-text"><-></span>
                            <input type="date" name="end_date_closing" class="form-control" aria-label="{{__('End date')}}" @if(!empty($filters) && isset($filters['end_date_closing'])) value="{{$filters['end_date_closing']}}" @endif>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{__('Status')}}</label>
                        <div class="row mb-3">
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" @if(isset($filters['status'][0])) checked @endif value="true" name="status[0]" id="status0"/>
                                <label class="form-check-label" for="status0">{{__('Open')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['status'][1])) checked @endif name="status[1]" id="status1"/>
                                <label class="form-check-label" for="status1">{{__('Pending Review')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['status'][2])) checked @endif name="status[2]" id="status2"/>
                                <label class="form-check-label" for="status2">{{__('In process')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['status'][3])) checked @endif name="status[3]" id="status3"/>
                                <label class="form-check-label" for="status3">{{__('Refused')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['status'][4])) checked @endif name="status[4]" id="status4"/>
                                <label class="form-check-label" for="status4">{{__('Completed')}}</label>
                            </div>
                        </div>
                        <label class="form-label">{{__('Impact')}}</label>
                        <div class="row">
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['impact'][0])) checked @endif name="impact[0]" id="impact0"/>
                                <label class="form-check-label" for="impact0">{{__('Urgent')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['impact'][1])) checked @endif name="impact[1]" id="impact1"/>
                                <label class="form-check-label" for="impact1">{{__('High')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['impact'][2])) checked @endif name="impact[2]" id="impact2"/>
                                <label class="form-check-label" for="impact2">{{__('Medium')}}</label>
                            </div>
                            <div class="form-check col-6">
                                <input class="form-check-input" type="checkbox" value="true" @if(isset($filters['impact'][3])) checked @endif name="impact[3]" id="impact3"/>
                                <label class="form-check-label" for="impact3">{{__('Low')}}</label>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-primary">{{__("Search")}}</button>
            </div>
        </div>
    </div>
</div>
</form>
<!-- End Filter -->

<form method="POST" action="">
    @csrf
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLabel">{{__("Create incidence")}}</h5>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
</form>

<table class="table table-hover table-striped">
    <thead>
        <th scope="col">@sortablelink('store',__('Store'))</th>
        <th scope="col">@sortablelink('status',__('Status'))</th>
        <th scope="col">@sortablelink('impact',__('Impact'))</th>
        <th scope="col">@sortablelink('responsable',__('Responsable'))</th>
        <th scope="col">@sortablelink('owner',__('Agent'))</th>
        <th scope="col">@sortablelink('created_at',__('Created'))</th>
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
                    {{$incidence->created_at}}
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
{{$incidences->appends([
        'filters' => $filters,
        'filtered' => 'yes'
    ])->links()}}
@endsection