<?php 
    $can_close = $incidence->closed<=date('Y-m-d',time());
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
{{session()->get('data')}}
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
                <input type="hidden" name="previousURL" id="previousURL" value="{{session()->get('data')}}">
                <div class="card-body m-sm-3 m-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>{{$incidence->store}}</strong>
                            <br />
                            {{$store->name}}
                        </div>
                        <div class="col-md-6  text-md-end">
                            @if($can_close) 
                                <button type="button" class="btn btn-outline-dark" @if($incidence->status==4) disabled @endif data-bs-toggle="modal" data-bs-target="#confirmModal">{{__('Complete')}}</button>
                            @else
                                @if($incidence->status == 4) 
                                    <button class="btn btn-outline-dark">{{__('Completed')}}</button>
                                @else
                                    @if($incidence->status == 2)
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 2) checked @endif value="2">
                                        <label class="btn btn-outline-success" for="success-outlined">{{__('In Process')}}</label>
                                        <button type="button" class="btn btn-outline-primary" @if($incidence->status==4) disabled @endif data-bs-toggle="modal" data-bs-target="#confirmWaitingModal">{{__('Waiting')}}</button>
                                        <button type="button" class="btn btn-outline-dark" @if($incidence->status==4) disabled @endif data-bs-toggle="modal" data-bs-target="#confirmModal">{{__('Complete')}}</button>
                                    @elseif($incidence->status == 1)
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="success-outlined" autocomplete="off" @if($incidence->status == 1) checked @endif value="2">
                                        <label class="btn btn-outline-success" for="success-outlined">{{__('Accept')}}</label>
                                        
                                        <input @if($incidence->status==4) disabled @endif  type="radio" class="btn-check" name="status" id="danger-outlined" autocomplete="off" @if($incidence->status == 3) checked @endif value="3">
                                        <label class="btn btn-outline-danger" for="danger-outlined">{{__('Refuse')}}</label>
                                    @elseif($incidence->status == 0)
                                    <a href="{{route('incidences.resend',['id' => $incidence->id])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="send"></i></a>
                                    @elseif($incidence->status == 5)
                                        <input @if($incidence->status==5) disabled @endif  type="radio" class="btn-check" name="status" id="primary-outlined" autocomplete="off" @if($incidence->status == 5) checked @endif value="5">
                                        <label class="btn btn-outline-primary" for="success-outlined">{{__('Waiting')}}</label>
                                        <button type="button" class="btn btn-outline-success" @if($incidence->status==4) disabled @endif data-bs-toggle="modal" data-bs-target="#confirmInProcessModal">{{__('In process')}}</button>
                                        <button type="button" class="btn btn-outline-dark" @if($incidence->status==4) disabled @endif data-bs-toggle="modal" data-bs-target="#confirmModal">{{__('Complete')}}</button>
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
                            <div class="text-muted">{{__("Typology")}}</div>
                            <strong>{{$incidence->typology}}</strong>
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
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#callInfo"><i class="align-middle" data-feather="layers"></i></button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" title="{{__('Call Store')}}" data-bs-target="#modalLlamadas" ><i class="align-middle" data-feather="phone"></i></button>
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
                        <textarea @if($incidence->status==4) disabled @endif  type="text" class="form-control" name="message" placeholder="{{__('Body message')}}" aria-label="Recipient's username" aria-describedby="button-addon2"></textarea>
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
                    <textarea name="reason" id="reason" class="form-control" style="visibility:hidden;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Call Store')}}" onClick="call('{{route('call.incidence',['id' => $incidence->id, 'user' => auth()->user()->id])}}')"><i class="align-middle" data-feather="phone"></i></button>
                    <button id="closeIncidence" class="btn btn-outline-danger">{{__('Complete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmWaitingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('incidences.wait',['id' => $incidence->id])}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Confirm waiting incidence')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3"> 
                    <p class="mb-0" style="color:red;text-align:center">{{__('Are you sure you want to put the incidence on hold?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button id="closeIncidence" class="btn btn-outline-success">{{__('Yes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmInProcessModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('incidences.process',['id' => $incidence->id])}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Confirm in process incidence')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3"> 
                    <p class="mb-0" style="color:red;text-align:center">{{__('Are you sure you want to set the incidence in process?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button id="closeIncidence" class="btn btn-outline-success">{{__('Yes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="CallInfo" id="callInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CallInfo">{{__('Information Calls')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body m-3">
      @if($incidence->calls != null && $incidence->calls != '')
      @foreach($incidence->calls as $call)
        <p style="font-size: 0.75em">{{__("Call ID")}}: {{$call['call_id']}}</p>
        <p style="font-size: 0.75em">{{__("Status")}}: <strong>{{$call['last_state']}}</strong></p>
        <table style="font-size:0.75em;width:100%">
          <tr>
            <td>{{__("Init call")}}: {{$call['start_time']}}</td>
            <td>{{__("Answered call")}}: {{$call['answered_time']}}</td>
            <td>{{__("Finish call")}}: {{$call['end_time']}}</td>
          </tr>
          <tr>
            <td>{{__("Total duration")}}: {{$call['total_duration']}}</td>
            <td>{{__("Incall duration")}}: {{$call['incall_duration']}}</td>
          </tr>
        </table>
        @if($call['record']!=null) 
        <div class="m-3 essential_audio" data-url="{{$call['record']}}">
          <span class="no_js">Please activate JavaScript for the audio player.</span>
        </div>
        @endif
        <hr>
      @endforeach
      @endif
      </div>

    </div>
  </div>
</div>

<!-- selector de llamadas -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalLlamadas" id="modalLlamadas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__("Call")}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <p class="mb-3">
                        
                        <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Call Store')}}" onClick="call('{{route('call.incidence',['id' => $incidence->id, 'user' => auth()->user()->id])}}')">
                            {{__("Call default number")}}    
                            <i class="align-middle" data-feather="phone"></i>
                        </button>
                    </p>
                    <div class="row">
                        <p class="mb-1">{{__("Different number")}}</p>
                        <div class="col-sm"><input type="text" class="form-control col-xs-3" id="phonenumber"/></div>
                        <div class="col-sm">                        
                            <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Call Store')}}" 
                            onClick="call('{{route('call.incidence',['id' => $incidence->id, 'user' => auth()->user()->id])}}', 'true')">
                            <i class="align-middle" data-feather="phone"></i>
                        </button>
                        </div>
                        <a  id="error" style="color:red"><a>
                    </div>
                </div>                  
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>         
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script  src="{{ asset('js/essential_audio.js') }}"></script>
<script>
function call(url, tlf = false) {

    if($("#error").val != ""){
        $("#error").text("");
    }

    //Validar que el teléfono sea correcto
    if(tlf) {
        var error = false
        const number = $( "#phonenumber" ).val().trim()
        if(number != ''){
            if (/^[0-9]+$/.test(number) != true) {
                error = true
            }
        }
        if(error){
            $("#error").text("Wrong format")
        }else {
           url = url.concat('&phonenumber=',number)
           let xhr = new XMLHttpRequest();
           xhr.open("GET", url);
           xhr.send();
           $('#closeIncidence').css('visibility','visible');
        }
        
    }else {
        let xhr = new XMLHttpRequest();
           xhr.open("GET", url);
           xhr.send();
           $('#closeIncidence').css('visibility','visible');
    }

}

$(document).ready(function() {
    if({{$incidence->callid == null}}==1) {
        $('#closeIncidence').css('visibility','hidden');
        $('#reason').css('visibility','visible');
    }
    $('#reason').on('change',function () {
        $('#closeIncidence').css('visibility','visible');
    })
});
</script>
@endsection