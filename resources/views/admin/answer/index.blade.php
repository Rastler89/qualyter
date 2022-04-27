@extends('layouts.dashboard')

@section('content')
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
                                @case(3) {{__('Sended')}} @break
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
                            @else 
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