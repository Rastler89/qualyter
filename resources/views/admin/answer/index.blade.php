@extends('layouts.dashboard')

@section('content')
<div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filters"><i class="align-middle" data-feather="filter"></i></button>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#downloadCSV"><i class="align-middle" data-feather="download"></i></button>
</div>

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
                                <label for="workOrder" class="form-label">{{__('Work Order')}}</label>
                                <input type="text" list="workOrder" class="form-control" name="workOrder" placeholder="{{__('Work Order')}}" @if(!empty($filters) && isset($filters['workOrder'])) value="{{$filters['client']}}" @endif/>
                                <datalist id="workOrder">
                                    @foreach($workOrders as $workOrder)
                                        <option value="{{$workOrder->code}}">{{$workOrder->code}} - {{$workOrder->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="agent" class="form-label">{{__('Agent')}}</label>
                                <input type="text" list="agents" class="form-control" name="agent" placeholder="{{__('Agent')}}" @if(!empty($filters) && isset($filters['agent'])) value="{{$filters['agent']}}" @endif/>
                                <datalist id="agents">
                                    @foreach($agents as $agent)
                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="team" class="form-label">{{__('Team')}}</label>
                                <input type="text" list="teams" class="form-control" name="team" placeholder="{{__('Team')}}" @if(!empty($filters) && isset($filters['team'])) value="{{$filters['team']}}" @endif/>
                                <datalist id="teams">
                                    @foreach($teams as $team)
                                        <option value="{{$team->url}}">{{$team->url}} - {{$team->name}}</option>
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
                                    <input class="form-check-input" type="checkbox" @if(isset($filters['status'][2])) checked @endif value="true" name="status[2]" id="status2"/>
                                    <label class="form-check-label" for="status2">{{__('Complete for QC')}}</label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="checkbox" @if(isset($filters['status'][3])) checked @endif value="true" name="status[3]" id="status3"/>
                                    <label class="form-check-label" for="status3">{{__('Pending reply')}}</label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="checkbox" @if(isset($filters['status'][4])) checked @endif value="true" name="status[4]" id="status4"/>
                                    <label class="form-check-label" for="status4">{{__('Pending Review')}}</label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="checkbox" @if(isset($filters['status'][5])) checked @endif value="true" name="status[5]" id="status5"/>
                                    <label class="form-check-label" for="status">{{__('Complete')}}</label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="checkbox" @if(isset($filters['status'][8])) checked @endif value="true" name="status[8]" id="status8"/>
                                    <label class="form-check-label" for="status8">{{__('Cancelled')}}</label>
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

<div class="modal fade" id="downloadCSV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{__('Export CSV')}}*</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" action="{{route('export.answer')}}">
        @csrf
        <p style="text-align:center;font-size:0.7em">*{{__("will only export between the dates indicated")}}</p>
        <div class="modal-body">
        <label>{{__('Search among')}}:</label>
        <div class="input-group mb-3">
            <input type="date" name="start_date" class="form-control" aria-label="{{__('Start date')}}">
            <span class="input-group-text"><-></span>
            <input type="date" name="end_date" class="form-control" aria-label="{{__('End date')}}">
        </div>
        <div class="mb-3">
            <label for="client" class="form-label">{{__('Client')}}</label>
            <input class="form-control" list="clients" id="client" name="client" placeholder="{{__('Type to search...')}}" />
            <datalist id="clients">
                @foreach($clients as $client)  
                    <option value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
            </datalist>
        </div>
        <div class="mb-3">
            <label for="store" class="form-label">{{__('Store')}}</label>
            <input class="form-control" list="stores" id="store" name="store" placeholder="{{__('Type to search...')}}" />
            <datalist id="stores">
                @foreach($stores as $store)  
                    <option value="{{$store->code}}">{{$store->name}}</option>
                @endforeach
            </datalist>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button class="btn btn-success">{{__('Export')}}</button>
      </div>
</form>
    </div>
  </div>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">@sortablelink('store',__('Store'))</th>
            <th scope="col">@sortablelink('client',__('Client'))</th>
            <th scoep="col">@sortablelink('status',__('Status'))</th>
            <th scope="col">@sortablelink('expiration',__('Expiration'))</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
            @foreach($stores as $store)
                @if($store->code == $answer->store && $store->client == $answer->client)
                    
                    @switch($answer->status)
                        @case(5)
                        @case(2) <tr class="table-success"> @break
                        @case(4) <tr class="table-warning"> @break
                        @case(4) <tr class="table-danger"> @break
                        @case(8) <tr class="table-dark"> @break
                    @endswitch

                        <td>
                            {{$store->name}}
                        </td>
                        <td>
                            @foreach($clients as $client)
                                @if($client->id == $answer->client)
                                    {{$client->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @switch($answer->status)
                                @case(2) {{__('Completed by QC')}} @break
                                @case(3) {{__('Send')}} @break
                                @case(4) {{__('Pending Review')}} @break
                                @case(5) {{__('Completed')}} @break
                                @case(8) {{__('Cancelled')}}
                            @endswitch
                        </td>
                        <td>
                            {{$answer->expiration}}
                        </td>
                        <td>
                            @if($answer->status == 8)
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#alloy"><i class="align-middle" data-feather="eye"></i></button>
                            @elseif($answer->status != 3)
                                <a class="btn btn-outline-primary" href="{{route('answers.view', ['id'=>$answer->id])}}"><i class="align-middle" data-feather="eye"></i></a>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#technician{{$answer->id}}"><i class="align-middle" data-feather="send"></i></button>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
{{$answers->appends([
        'filters' => $filters,
        'filtered' => 'yes'
    ])->links()}}
@foreach($answers as $answer)
    @if($answer->status == 8)
    <div class="modal fade" id="alloy" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @foreach($stores as $store)
                        @if($store->code == $answer->store && $store->client == $answer->client)
                    <h5 class="modal-title">{{$store->name}}</h5>
                        @endif
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <p class="mb-0">{{$answer->answer}}</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('answers.reactivate', ['id' => $answer->id]) }}" class="btn btn-outline-danger">{{__("Activate")}}</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
    @elseif($answer->status != 3)
    <form method="POST" action="{{route('answers.send', ['id'=>$answer->id])}}">
        @csrf
    <div class="modal fade" id="technician{{$answer->id}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <textarea name="emails" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">{{__("Send emails")}}
                </div>
            </div>
        </div>
    </div>
    </form>
    @endif
@endforeach
@endsection