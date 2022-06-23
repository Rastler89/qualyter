@extends('layouts.agent')

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
            <form method="POST" action="{{route('incidences.update',['id' => $incidence->id])}}">
                @csrf
                <input type="hidden" name="agent" value="{{$agent->name}}" />
                <div class="card-body m-sm-3 m-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>{{$incidence->store}}</strong>
                            <br />
                            {{$store->name}}
                        </div>
                        <div class="col-md-6  text-md-end">
                        @switch($incidence->status)
                            @case(0)
                                {{__('Open')}}
                                @break;
                            @case(1)
                                {{__('Pending review')}}
                                @break;
                            @case(2)
                                {{__('Process')}}
                                @break;
                            @case(3)
                                {{__('Refused')}}
                                @break;
                            @case(4)
                                {{__('Complete')}}
                                @break;
                        @endswitch
                        </div>

                        
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
                            <div class="text-muted">{{__('Created day')}}</div>
                            <strong>{{$incidence->created_at}}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-muted">{{__('Expiration Date')}}</div>
                            <strong>
                                {{$order->expiration}}
                            </strong>
                            <div class="text-muted">{{__('Closed Day')}}</div>
                            <input class="form-control" type="date" id="closed" name="closed" value="{{$incidence->closed->format('Y-m-d')}}" />
                        </div>
                    </div>

                    <hr class="my-4" />

                    <ul class="chat">
                        @foreach($comments as $comment)
                        <li class="body-message @if($comment->type == 'agent') m-user @else m-agent @endif">
                        @if(isset($comment->date)) <i><?php echo(date('d-m-Y H:i:s', strtotime($comment->date))); ?></i> @endif<strong>{{$comment->owner}}:</strong>
                            {{$comment->message}}
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="message" aria-label="With textarea"></textarea>
                        <button class="btn btn-outline-primary btn-lg" id="button-addon2"><i class="align-middle" data-feather="send"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection