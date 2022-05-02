@extends('layouts.dashboard')

@section('content')<!--
<div class="btn-group" role="group" aria-label="Basic mixed styles example">
  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#downloadCSV"><i class="align-middle" data-feather="download"></i></button>
</div>
<div class="modal fade" id="downloadCSV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{__('Export CSV')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="">
          @csrf
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
        <div class="mb-3">
            <label for="agent" class="form-label">{{__('Agent')}}</label>
            <input class="form-control" list="agents" id="agent" name="agent" placeholder="{{__('Type to search...')}}" />
            <datalist id="agents">
                @foreach($agents as $agent)  
                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                @endforeach
            </datalist>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button type="button" class="btn btn-success">{{__('Export')}}</button>
      </div>
</form>
    </div>
  </div>
</div>-->
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
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
{{$answers->links()}}
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection