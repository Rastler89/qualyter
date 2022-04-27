@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
    <a class="btn btn-primary" href="{{route('workorder.new')}}">{{__('Add Work Order')}}</a>
</div>

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
                    <div class="mb-3">
                        <label for="workorder" class="form-label">{{__('Work Order')}}</label>
                        <input type="text" class="form-control" name="workorder" placeholder="{{__('Work Order')}}" />
                    </div>
                    <button class="btn btn-danger">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">@sortablelink('store',__('Store'))</th>
            <th scope="col">@sortablelink('client',__('Client'))</th>
            <th scope="col">@sortablelink('expiration',__('Expiration'))</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
            @foreach($stores as $store)
                @if($store->code == $answer->store && $store->client == $answer->client)
                    @if($store->phonenumber==null && $store->email==null)
                    <tr class="table-dark">
                    @else
                        @switch($answer->status)
                            @case(0) <tr class="table-success"> @break
                            @case(1) <tr class="table-warning"> @break
                            @case(3) <tr class="table-danger"> @break
                        @endswitch
                    @endif
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
                            {{$answer->expiration}}
                        </td>
                        <td>
                    @if($store->phonenumber!=null)
                        <a href="{{route('tasks.view',['id'=>$answer->id])}}" class="btn btn-outline-primary @if($answer->user != $id && $answer->user != null) disabled @endif"><i class="align-middle" data-feather="phone"></i></a>
                    @elseif($store->email!=null)
                        <a href="#" class="btn btn-outline-primary @if($answer->user != null && $answer->user != $id) disabled @endif"><i class="align-middle" data-feather="send"></i></a>
                    @else 
                        <?php $id = str_replace('/','_',$store->code); ?>
                        <a href="{{route('stores.edit',['id'=>$id])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a>
                    @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
{{$answers->appends(['client' => $filterClient, 'store' => $filterStore, 'workorder' => $filterWO])->links()}}
@endsection