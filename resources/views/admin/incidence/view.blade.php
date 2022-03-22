@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @switch($incidence->impact)
            @case(0)
            <div class="card" style="border: 5px solid red">
                <div class="card-header" style="text-align:center;background:red;color:white;">
                @break;
            @case(1)
            <div class="card" style="border: 5px solid orange">
                <div class="card-header" style="text-align:center;background:orange;color:white;">
                @break;
            @case(2)
            <div class="card" style="border: 5px solid #fcb92c">
                <div class="card-header" style="text-align:center;background:#fcb92c;color:white;">
                @break
            @case(3)
            <div class="card" style="border: 5px solid green">
                <div class="card-header" style="text-align:center;background:green;color:white;">
                @break
        @endswitch
                <h3 style="color:@if($incidence->impact==2) black @else white @endif">
                    @switch($incidence->impact)
                        @case(0)
                            {{__('Urgent')}}
                            @break;
                        @case(1)
                            {{__('High')}}
                            @break;
                        @case(2)
                            {{__('Medium')}}
                            @break
                        @case(3)
                            {{__('Low')}}
                            @break
                    @endswitch
                </h3>
            </div>
            <form method="POST" action="{{route('incidences.modify',['id' => $incidence->id])}}">
                @csrf
                <div class="card-body m-sm-3 m-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>{{$incidence->store}}</strong>
                            <br />
                            {{$store->name}}
                        </div>
                        <div class="col-md-6  text-md-end">
                            @if($incidence->status == 4) 
                                <button class="btn btn-outline-dark">{{__('Completed')}}</button>
                            @else
                                @if($incidence->status == 2)
                                    <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 2) checked @endif value="2">
                                    <label class="btn btn-outline-success" for="success-outlined">{{__('In Process')}}</label>
                                    
                                    <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="4">
                                    <label class="btn btn-outline-dark" for="danger-outlined">{{__('Complete')}}</label>
                                @else
                                    <input type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 1) checked @endif value="2">
                                    <label class="btn btn-outline-success" for="success-outlined">{{__('Accept')}}</label>
                                    
                                    <input type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" @if($incidence->status == 3) checked @endif value="3">
                                    <label class="btn btn-outline-danger" for="danger-outlined">{{__('Refuse')}}</label>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-muted">{{__('Responsable')}}</div>
                            <strong>{{$user->name}}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-muted">{{__('Agent')}}</div>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#defaultModalPrimary">
                                <i class="align-middle" data-feather="edit"></i>
                            </button>
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
                                <input class="form-control" type="date" id="closed" name="closed" value="{{$incidence->closed->format('Y-m-d')}}" />
                            </strong>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <ul class="chat">
                        @foreach($comments as $comment)
                        <li class="body-message @if($comment->type == 'user') m-user @else m-agent @endif">
                            <strong>{{$comment->owner}}:</strong>
                            {{$comment->message}}
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="message" placeholder="{{__('Body message')}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" id="button-addon2"><i class="align-middle" data-feather="send"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('incidences.changeAgent',['id' => $incidence->id])}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Change Agent')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <p class="mb-0" style="color:red;text-align:center">{{__('Are you sure about changing the agent?
                        This change affects the mailing of the incidents, please check that everything is correct before doing so.')}}</p>
                    <select name="agent" class="form-select">
                        @foreach($agents as $ag)
                            <option value="{{$ag->id}}">{{$ag->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button class="btn btn-outline-danger">{{__('Change Agent')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection