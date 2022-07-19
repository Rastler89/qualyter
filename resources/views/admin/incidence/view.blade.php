<?php 
    $can_close = $incidence->closed>=date('Y-m-d',time());
?>
@extends('layouts.dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@endsection

@section('content')
<div class="row">
  <div class="col-6 d-grid gap-2 d-md-flex mb-3">
      <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="align-middle" data-feather="chevron-left"></i></a>
  </div>
</div>
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
                            @if($can_close) 
                                <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="4" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                <label class="btn btn-outline-dark" for="danger-outlined">{{__('Complete')}}</label>
                            @else
                                @if($incidence->status == 4) 
                                    <button class="btn btn-outline-dark">{{__('Completed')}}</button>
                                @else
                                    @if($incidence->status == 2)
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 2) checked @endif value="2">
                                        <label class="btn btn-outline-success" for="success-outlined">{{__('In Process')}}</label>
                                        
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" value="4" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                        <label class="btn btn-outline-dark" for="danger-outlined">{{__('Complete')}}</label>
                                    @elseif($incidence->status == 1)
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 1) checked @endif value="2">
                                        <label class="btn btn-outline-success" for="success-outlined">{{__('Accept')}}</label>
                                        
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" @if($incidence->status == 3) checked @endif value="3">
                                        <label class="btn btn-outline-danger" for="danger-outlined">{{__('Refuse')}}</label>
                                    @elseif($incidence->status == 0)
                                    <a href="{{route('incidences.resend',['id' => $incidence->id])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="send"></i></a>
                                    @else
                                        <button class="btn btn-outline-dark">{{__('Refused')}}</button>
                                    @endif
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
                            @if($incidence->status != 4)
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#defaultModalPrimary">
                                <i class="align-middle" data-feather="edit"></i>
                            </button>
                            @endif
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
                            <div class="text-muted">{{__('Created day')}}</div>
                            <strong>{{$incidence->created_at}}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-muted">{{__('Expiration Date')}}</div>
                            <strong>
                                {{$order->expiration}}
                            </strong>
                            <div class="text-muted">{{__('Control Day')}}</div>
                            <strong class="input-group">
                                <input @if($incidence->status==4) disabled @endif  class="form-control" type="date" id="closed" name="closed" value="{{$incidence->closed->format('Y-m-d')}}" />
                                @if($incidence->status != 4)
                                <button class="btn btn-outline-primary" id="button-send"><i class="align-middle" data-feather="save"></i></button>
                                @endif
                            </strong>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <div class="conversation">
                        <div class="conversation-container">
                        @foreach($comments as $comment)
                        <div class="message @if($comment->owner == $owner->name) sent @else received @endif">
                            <strong>{{$comment->owner}}:</strong>
                            {{$comment->message}}
                            @if(isset($comment->date)) <span class="metadata"><span class="time"><?php echo(date('d-m-Y H:i:s', strtotime($comment->date))); ?></span></span> @endif
                        </div>
                        @endforeach
                        </div>
                    </div>
                    
                    <div class="input-group mb-3">
                        <input @if($incidence->status==4) disabled @endif  type="text" class="form-control" name="message" placeholder="{{__('Body message')}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                        @if($incidence->status != 4)
                        <button class="btn btn-outline-primary" id="button-addon2"><i class="align-middle" data-feather="send"></i></button>
                        @endif
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

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('incidences.complete',['id' => $incidence->id])}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Confirm complete incidence')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <p class="mb-0" style="color:red;text-align:center">{{__('Are you sure that the incident has been completed? First of all make sure, customer satisfaction is very important.')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button class="btn btn-outline-danger">{{__('Complete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection