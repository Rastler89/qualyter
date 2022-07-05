@extends('layouts.dashboard')

@section('content')
<div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filters"><i class="align-middle" data-feather="filter"></i></button>
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('clients.new')}}">{{__('Add Client')}}</a>
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
                            <label for="client" class="form-label">{{__('Client`s Name')}}</label>
                            <input type="text" class="form-control" name="client" placeholder="{{__('Client`s Name')}}" @if(!empty($filters) && isset($filters['client'])) value="{{$filters['client']}}" @endif/>
                        </div>
                        <div class="col-md-4">
                            <label for="father" class="form-label">{{__('Father')}}</label>
                            <input type="text" list="father" class="form-control" name="father" placeholder="{{__('Father')}}" @if(!empty($filters) && isset($filters['father'])) value="{{$filters['father']}}" @endif/>
                            <datalist id="father">
                                <option value="--" selected>{{__("Nothing")}}</option>
                                @foreach($fathers as $father)
                                    <option value="{{$father->id}}">{{$father->id}} - {{$father->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="central" name="central" @if(isset($filters['central'])) checked @endif>
                                <label class="form-check-label" for="central">{{__("Is Father")}}</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="extra" name="extra" @if(isset($filters['extra'])) checked @endif>
                                <label class="form-check-label" for="extra">{{__("Have extra information")}}</label>
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

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">@sortablelink('name',__('Name'))</th>
            <th scope="col">@sortablelink('delegation',__('Delegation'))</th>
            <th scope="col">{{__('Phone Number')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col">{{__('Language')}}</th>
            <th scoep="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client) 
        <tr>
            <td>{{$client->name}}</td>
            <td>{{$client->delegation}}</td>
            <td>{{$client->phonenumber}}</td>
            <td>{{$client->email}}</td>
            <td>{{$client->language}}</td>
            <td>
                <a href="{{route('clients.edit',['id'=>$client->id])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a>
                @if($client->delegation=='00' || $client->father == null)<a href="{{route('public.index',['id'=>$client->id])}}" target="_blank" class="btn btn-outline-success"><i class="align-middle" data-feather="activity"></i></a>@endif
                @if($client->delegation=='00' || $client->father == null)<a href="{{route('clients.send',['id'=>$client->id])}}" class="btn btn-outline-danger"><i class="align-middle" data-feather="send"></i></a>@endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$clients->appends([
        'filters' => $filters,
        'filtered' => 'yes'
    ])->links()}}
@endsection