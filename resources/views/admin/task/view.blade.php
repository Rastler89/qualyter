@extends('layouts.dashboard')

@section('sytles')
<link rel="stylesheet" href="{{ asset("css/custom.css") }}">
<link rel="stylesheet" href="{{ asset("css/essential_audio.css") }}">
@endsection

@section('content')
<div class="row">
  <div class="col-6 d-grid gap-2 d-md-flex mb-3">
      <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="align-middle" data-feather="chevron-left"></i></a>
  </div>
  <div class="col-6 d-grid gap-2 d-md-flex justify-content-md-end mb-3">
      <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#cancelVisit">{{__('Cancel')}}</button>
  </div>
</div>

<!-- Modal cancel -->
<div class="modal fade" id="cancelVisit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{route('tasks.cancel', ['id' =>$answer->id])}}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('Explains the reason for canceling the visit.')}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea name="reason" class="form-control"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
          <button class="btn btn-danger">{{__('Cancel visit')}}</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Incidencias a biertas -->
@if($answer->incidence > 0 )
<div class="alert alert-warning">
  <b>{{__('This store still have incidences pending to be solved.')}}</b>
</div>
@endif
<!-- Table -->
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <p><strong>{{__('Name')}}</strong></p>
            <p>{{$store->name}}</p>
          </div>
          <div class="col">
            <p><strong>{{__('Language')}}</strong></p>
            <p>{{$store->language}}</p>
          </div>
          <div class="col">
            <p><strong>{{__('Phone Number')}}</strong></p>
            {{$store->phonenumber}}
            @if($store->phonenumber != '-')
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#callInfo"><i class="align-middle" data-feather="list"></i></button>
            @endif
          </div>
          <div class="col" style="position:relative;">
            <button id="phoneNumber" class="btn btn-outline-primary" style="position:absolute;">{{__('Calling')}}</button>
            <div class="mb-3">
            @if($store->email == '-')
            
            <button id="notRespond" class="btn btn-danger" style="visibility:hidden;">{{__('No email')}}</button>
              @if($store->whatsapp == 1)
                <a id="whatsapp" class="btn btn-success" style="visibility:hidden;" href="{{route('tasks.notrespond', ['id'=>$answer->id, 'type'=>'whatsapp'])}}">{{__('Whatsapp')}}</a>
              @endif 
            </div>
            @else
            <div class="mb-3">
              <a id="notRespond" class="btn btn-danger" style="visibility:hidden;" href="{{route('tasks.notrespond', ['id'=>$answer->id, 'type'=>'mail'])}}">{{__('Not respond')}}</a>
              @if($store->whatsapp == 1)
              <a id="whatsapp" class="btn btn-success" style="visibility:hidden;" href="{{route('tasks.notrespond', ['id'=>$answer->id, 'type'=>'whatsapp'])}}">{{__('Whatsapp')}}</a>
              @endif    
            </div>
            @endif
          </div>
          <button id="recall" class="btn btn-outline-primary" style="visibility:hidden;" onClick="call()">{{__('Recall')}}</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-4 col-sm-4">
    <div class="accordion" id="workOrder" style="position:sticky;">
      @foreach($tasks as $task)
      <!-- TODO: link to store's incidence -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
            {{$task->code}} {{$task->name}}
          </button>
        </h2>
        <div id="collapse{{$loop->index}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#workOrder">
          <div class="accordion-body">
            <p><strong>@foreach($agents as $agent) @if($agent->id==$task->owner) {{$agent->name}} @endif @endforeach</strong></p>
            <p>{{$task->priority}}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="col-8 col-sm-8">
    <form method="POST" action="{{route('tasks.response', ['id' => $answer->id])}}" id="questionary">
      @csrf
      <h4>{{__('Progress')}}</h4>
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">%</div>
      </div>
      <div class="form-dynamic">
        <div id="part1" class="question">
          <h4>{{__('What overall score would you give us?')}}</h4>
          <div class="mb-3">
            <div class="legend" style="--s:80px">
              <label>{{__('Suspense')}}</label>
              <label>{{__('Sufficient')}}</label>
              <label>{{__('Regular')}}</label>
              <label>{{__('Remarkable')}}</label>
              <label>{{__('Excelent')}}</label>
            </div>
            <div class="rating" style="--s:80px">
              <input type="radio" name="valoration1" value="5" id="valoration1-5"><label for="valoration1-5">5</label>
              <input type="radio" name="valoration1" value="4" id="valoration1-4"><label for="valoration1-4">4</label>
              <input type="radio" name="valoration1" value="3" id="valoration1-3"><label for="valoration1-3">3</label>
              <input type="radio" name="valoration1" value="2" id="valoration1-2"><label for="valoration1-2">2</label>
              <input type="radio" name="valoration1" value="1" id="valoration1-1"><label for="valoration1-1">1</label>
            </div>
          </div>
          <div class="mb-3">
            <label for="comment1" class="form-label">{{__('Comments')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
            <textarea class="form-control" id="comment1" name="comment1" row="3"></textarea>
          </div>
          <button type="button" id="next1" onclick="next(2)" style="width:100%;visibility:hidden;" class="btn btn-primary btn-lg btn-block">Next</button>
        </div>
        <div id="part2" class="question">
          <h4>{{__('Rate the speed of our service')}}</h4>
          <div class="mb-3">
            <div class="legend" style="--s:80px">
              <label>{{__('Very slow')}}</label>
              <label>{{__('Slow')}}</label>
              <label>{{__('Normal')}}</label>
              <label>{{__('Fast')}}</label>
              <label>{{__('Very fast')}}</label>
            </div>
            <div class="rating" style="--s:80px">
              <input type="radio" name="valoration2" value="5" id="valoration2-5"><label for="valoration2-5">5</label>
              <input type="radio" name="valoration2" value="4" id="valoration2-4"><label for="valoration2-4">4</label>
              <input type="radio" name="valoration2" value="3" id="valoration2-3"><label for="valoration2-3">3</label>
              <input type="radio" name="valoration2" value="2" id="valoration2-2"><label for="valoration2-2">2</label>
              <input type="radio" name="valoration2" value="1" id="valoration2-1"><label for="valoration2-1">1</label>
            </div>
            <div class="mb-3">
              <label for="comment2" class="form-label">{{__('Comments')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
              <textarea class="form-control" id="comment2" name="comment2" row="3"></textarea>
            </div>
            <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
              <button type="button" onclick="prev(2)" style="width:50%" class="btn btn-primary btn-lg">{{__('Previous')}}</button>
              <button id="next2" type="button" onclick="next(3)" style="width:50%;visibility:hidden;" class="btn btn-primary btn-lg">{{__('Next')}}</button>
            </div>
          </div>
        </div>
        <div id="part3" class="question">
          <h4>{{__('Appreciates the friendliness of our technicians')}}</h4>
          <div class="mb-3">
            <div class="legend" style="--s:80px">
              <label>{{__('Very bad')}}</label>
              <label>{{__('Bad')}}</label>
              <label>{{__('Normal')}}</label>
              <label>{{__('Well')}}</label>
              <label>{{__('Very good')}}</label>
            </div>
            <div class="rating" style="--s:80px">
              <input type="radio" name="valoration3" value="5" id="valoration3-5"><label for="valoration3-5">5</label>
              <input type="radio" name="valoration3" value="4" id="valoration3-4"><label for="valoration3-4">4</label>
              <input type="radio" name="valoration3" value="3" id="valoration3-3"><label for="valoration3-3">3</label>
              <input type="radio" name="valoration3" value="2" id="valoration3-2"><label for="valoration3-2">2</label>
              <input type="radio" name="valoration3" value="1" id="valoration3-1"><label for="valoration3-1">1</label>
            </div>
            <div class="mb-3">
              <label for="comment3" class="form-label">{{__('Comments')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
              <textarea class="form-control" id="comment3" name="comment3" row="3"></textarea>
            </div>
            <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
              <button type="button" onclick="prev(3)" style="width:50%" class="btn btn-primary btn-lg">{{__('Previous')}}</button>
              <button id="next3" type="button" onclick="next(4)" style="width:50%;visibility:hidden;" class="btn btn-primary btn-lg">{{__('Next')}}</button>
            </div>
          </div>
        </div>
        <div id="part4" class="question">
          <h4>{{__('Scores the resolution capacity of the incidences')}}</h4>
          <div class="mb-3">
            <div class="legend" style="--s:80px">
              <label>{{__('Very bad')}}</label>
              <label>{{__('Bad')}}</label>
              <label>{{__('Normal')}}</label>
              <label>{{__('Well')}}</label>
              <label>{{__('Very good')}}</label>
            </div>
            <div class="rating" style="--s:80px">
              <input type="radio" name="valoration4" value="5" id="valoration4-5"><label for="valoration4-5">5</label>
              <input type="radio" name="valoration4" value="4" id="valoration4-4"><label for="valoration4-4">4</label>
              <input type="radio" name="valoration4" value="3" id="valoration4-3"><label for="valoration4-3">3</label>
              <input type="radio" name="valoration4" value="2" id="valoration4-2"><label for="valoration4-2">2</label>
              <input type="radio" name="valoration4" value="1" id="valoration4-1"><label for="valoration4-1">1</label>
            </div>
            <div class="mb-3">
              <label for="comment4" class="form-label">{{__('Comments')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
              <textarea class="form-control" id="comment4" name="comment4" row="3"></textarea>
            </div>
            <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
              <button type="button" onclick="prev(4)" style="width:50%" class="btn btn-primary btn-lg">{{__('Previous')}}</button>
              <button id="next4" type="button" onclick="next(5)" style="width:50%;visibility:hidden;" class="btn btn-primary btn-lg">{{__('Next')}}</button>
            </div>
          </div>
        </div>
        <div id="part5" class="question">
          <h4>{{__("Technicians' mails")}}</h4>
          <div class="mb-3">
            <div class="mb-3">
              <textarea class="form-control" id="emails" name="emails" row="3"></textarea>
            </div>
            <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
              <button id="next4" type="button" onclick="next(6)" style="width:50%;" class="btn btn-primary btn-lg">{{__('Next')}}</button>
            </div>
          </div>
        </div>
        <div id="part6" class="question">
          <h4>{{__('Has there been any impact on this visit?')}}</h4>
          <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
            <button type="button" style="width:50%" class="btn btn-danger btn-lg" onclick="showIncidence()">{{__('Yes')}}</button>
            <button type="button" style="width:50%" class="btn btn-success btn-lg" onclick="sendForm()">{{__('No (Close Questionnaire)')}}</button>
          </div>
          <div class="mb-3" id="incidence">
            <div id="firstIncidence">
              <label for="responsable" class="form-label">{{__('Responsable')}}</label>
              <select class="form-select form-select mb-3" id="responable[]" name="responsable[]" required>
                <option value="--" selected>{{__('Please select responsable')}}</option>
                @foreach($owners as $owner)
                <optgroup label="{{$owner->name}}">
                  @foreach($tasks as $task)
                    @if($task->owner == $owner->id)
                      <option value="{{$task->owner}}-{{$task->code}}">{{$task->name}}</option>
                    @endif
                  @endforeach
                </optgroup>
                @endforeach;
              </select>
              <label for="typology" class="form-label">{{__("Typology")}}</label>
              <select class="form-select form-select-lg mb-3" id="typology[]" name="typology[]" required>
                <option selected>{{__('Please selecte one')}}</option>
                @foreach($typologies as $typology)
                <option value="{{$typology->id}}">{{$typology->name}}</option>
                @endforeach
              </select>
              <label for="impact" class="form-label">{{__('Impact')}}</label>
              <select class="form-select form-select-lg mb-3" id="impact[]" name="impact[]" required>
                <option selected>{{__('Please select impact')}}</option>
                <option value="0" style="background:red">{{__('Urgent')}}</option>
                <option value="1" style="background:orange">{{__('High')}}</option>
                <option value="2" style="background:yellow">{{__('Medium')}}</option>
                <option value="3" style="background:green;color:white;">{{__('Low')}}</option>
              </select>
              <div class="mb-3">
                <label for="comment" class="comment">{{__('Comment')}}</label>
                <textarea class="form-control" id="incidence[]" name="incidence[]" rows="3" required></textarea>
              </div>
            </div>
            <div id="moreIncidence"></div>
            <div class="d-grid gap-2 mx-auto mb-3">
              <button class="btn btn-outline-success" type="button" id="addIncidence"><i class="align-middle" data-feather="plus"></i></button>
            </div>
            <button style="width:100%" class="btn btn-primary btn-lg btn-block">{{__('Close Questionnaire')}}</button>
          </div>
          
        </div>
      </div>
    </form>
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
      @if($answer->calls != null && $answer->calls != '')
      @foreach($answer->calls as $call)
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

@endsection

@section('javascript')
<script>
var elements = 6;
var valueElement = 100/elements;
var lastValue = valueElement*(elements-2)
var totalSeconds = 0; var items = 0;
var countTime;
var elementPosition = $('#workOrder').offset();
var elementWidth = $('#workOrder').width();

$(document).ready(function() {
  $('input[type=radio][id=valoration1-1]').click(function() {
        $('input[type=radio][name=valoration1]').val(1)
    });
    $('input[type=radio][id=valoration1-2]').click(function() {
        $('input[type=radio][name=valoration1]').val(2)
    });
    $('input[type=radio][id=valoration1-3]').click(function() {
        $('input[type=radio][name=valoration1]').val(3)
    });
    $('input[type=radio][id=valoration1-4]').click(function() {
        $('input[type=radio][name=valoration1]').val(4)
    });
    $('input[type=radio][id=valoration1-5]').click(function() {
        $('input[type=radio][name=valoration1]').val(5)
    });
    $('input[type=radio][id=valoration2-1]').click(function() {
        $('input[type=radio][name=valoration2]').val(1)
    });
    $('input[type=radio][id=valoration2-2]').click(function() {
        $('input[type=radio][name=valoration2]').val(2)
    });
    $('input[type=radio][id=valoration2-3]').click(function() {
        $('input[type=radio][name=valoration2]').val(3)
    });
    $('input[type=radio][id=valoration2-4]').click(function() {
        $('input[type=radio][name=valoration2]').val(4)
    });
    $('input[type=radio][id=valoration2-5]').click(function() {
        $('input[type=radio][name=valoration2]').val(5)
    });
    $('input[type=radio][id=valoration3-1]').click(function() {
        $('input[type=radio][name=valoration3]').val(1)
    });
    $('input[type=radio][id=valoration3-2]').click(function() {
        $('input[type=radio][name=valoration3]').val(2)
    });
    $('input[type=radio][id=valoration3-3]').click(function() {
        $('input[type=radio][name=valoration3]').val(3)
    });
    $('input[type=radio][id=valoration3-4]').click(function() {
        $('input[type=radio][name=valoration3]').val(4)
    });
    $('input[type=radio][id=valoration3-5]').click(function() {
        $('input[type=radio][name=valoration3]').val(5)
    });
    $('input[type=radio][id=valoration4-1]').click(function() {
        $('input[type=radio][name=valoration4]').val(1)
    });
    $('input[type=radio][id=valoration4-2]').click(function() {
        $('input[type=radio][name=valoration4]').val(2)
    });
    $('input[type=radio][id=valoration4-3]').click(function() {
        $('input[type=radio][name=valoration4]').val(3)
    });
    $('input[type=radio][id=valoration4-4]').click(function() {
        $('input[type=radio][name=valoration4]').val(4)
    });
    $('input[type=radio][id=valoration4-5]').click(function() {
        $('input[type=radio][name=valoration4]').val(5)
    });
  $('input[type=radio][name=valoration1]').change(function() {
    $('#next1').css('visibility','visible');
    clearInterval(countTime);
  });
  $('input[type=radio][name=valoration2]').change(function() {
    $('#next2').css('visibility','visible');
  });
  $('input[type=radio][name=valoration3]').change(function() {
    $('#next3').css('visibility','visible');
  });
  $('input[type=radio][name=valoration4]').change(function() {
      $('#next4').css('visibility','visible');
  });
  $('#addIncidence').click(function(event) {
    $('#firstIncidence').clone().appendTo('#moreIncidence');
  })
  if($('input[type=radio][name=valoration1]').val().length > 0) {
    $('#next1').css('visibility','visible');
  }
  initTime();
});

$(window).scroll(function() {
  if($(window).scrollTop() > elementPosition.top) {
    $('#workOrder').css('position','fixed').css('top','50px').css('width',elementWidth);
  } else {
    $('#workOrder').css('position','static');
  }
})

function next(id) {
  progress = (id-1)*valueElement;

  if(progress<lastValue) {
    if($('input[type=radio][name=valoration'+id+']').val().length > 0) {
      $('#next'+id).css('visibility','visible');
    }
  }
  $('#next'+(id-1)).css('visibility','hidden');
  $('#part'+(id-1)).css('visibility','hidden');
  $('#part'+id).css('visibility','visible');
  $('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress); 
  $('.progress-bar').text(progress.toFixed(2)+'%');
}
function prev(id) {
  progress = (id-2)*valueElement;

  $('#part'+(id-1)).css('visibility','visible');
  $('#part'+id).css('visibility','hidden');
  $('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress); 
  $('.progress-bar').text(progress.toFixed(2)+'%');
  $('#next'+id).css('visibility','hidden');
}

function initTime() {
  countTime = setInterval(setTime,1000);
}

function setTime() {
  ++totalSeconds;
  if(totalSeconds == 30) {
    $('#phoneNumber').css('visibility','hidden');
    $('#notRespond').css('visibility','visible');
    $('#recall').css('visibility','visible');
    $('#whatsapp').css('visibility','visible');
  } 
}

function showIncidence() {
  $('#incidence').css('visibility','visible');
  $('#part5').css('position','relative');
}

function sendForm() {
  $('#questionary').submit();
}

function call() {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "{{route('call.answer',['id' => $answer->id, 'user' => auth()->user()->id])}}");
  xhr.send();
  console.log(xhr.responseText);
}


</script>
@endsection