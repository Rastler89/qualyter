@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" style="border: 5px solid red">
            <div class="card-header" style="text-align:center;background:red;color:white;">
                <h3 style="color:white">Urgente</h3>
            </div>
            <div class="card-body m-sm-3 m-md-5">
                <div class="mb-4">
                    <strong>{{$incidence->store}}</strong>
                    <br />
                    {{$store->name}}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="text-muted">{{__('Responsable')}}</div>
                        <strong>{{$user->name}}</strong>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-muted">{{__('Agent')}}</div>
                        <strong>{{$agent->name}}</strong>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="text-muted">{{$order->code}}</div>
                        <strong>
                            {{$order->name}}
                        </strong>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="text-muted">{{__('Expiration Date')}}</div>
                        <strong>
                            {{$order->expiration}}
                        </strong>
                        <div class="text-muted">{{__('Closed Day')}}</div>
                        <strong>
                            <input class="form-control" type="date" value="{{$incidence->closed}}" id="closed" />
                        </strong>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="chat">
                    @foreach($comments as $comment)
                    {{$comment}}
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection