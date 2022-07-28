@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-6 d-grid gap-2 d-md-flex mb-3">
      <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="align-middle" data-feather="chevron-left"></i></a>
  </div>
</div>
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
            <p><strong>{{__('Expiration')}}</strong></p>
            <p>{{$answer->expiration}}</p>
          </div>
          <div class="col">
            <p></p>
            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#callInfo">{{__('Info Calls')}}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="@if($answer->status == 2 || $answer->status == 5) col-12 col-sm-12 @else col-4 col-sm-4 @endif">
    @if($answer->status != 2 && $answer->status != 5)
    <div class="accordion" id="workOrder" style="position:sticky;display:none;">
      @foreach($tasks as $task)
      <div class="accordion-item">
        <h2 class="accordion-header">
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
    @endif
    <div class="accordion" id="answer" style="position:sticky;">
      @foreach($answers as $ans)
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#answer{{$loop->index}}" aria-expanded="true" aria-controls="answer{{$loop->index}}">
            @switch($loop->index)
              @case(0) {{__('What overall score would you give us?')}} @break
              @case(1) {{__('Rate the speed of our service')}} @break
              @case(2) {{__('Appreciates the friendliness of our technicians')}} @break
              @case(3) {{__('Scores the resolution capacity of the incidences')}} @break
            @endswitch
          </button>
        </h2>
        <div id="answer{{$loop->index}}" class="collapse-answer answer show" aria-labelledby="headingOne" data-bs-parent="#workOrder">
          <div class="accordion-body">
            <p>{{$ans['value']}} {{__('stars')}}</p>
            <p><strong>{{__('Comments')}}:</strong> {{$ans['text']}}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @if($answer->status != 2 && $answer->status != 5) 
  <div class="col-8 col-sm-8" id="bodyIncidence">
    <div id="anyIncidence">
      <h4>{{__('Has there been any impact on this visit?')}}</h4>
      <form method="POST" action="{{route('answers.complete', ['id' =>$answer->id])}}">
        @csrf
        <div class="btn-group" role="group" aria-label="Incidence" style="width:100%">
          <button type="button" style="width:50%" class="btn btn-danger btn-lg" onclick="showIncidence()">{{__('Yes')}}</button>
          <button style="width:50%" class="btn btn-success btn-lg">{{__('No (Close Questionnaire)')}}</button>
        </div>
      </form>
    </div>
      <form method="POST" action="{{route('answers.revised',['id' => $answer->id])}}">
        @csrf
          <div class="mb-3" id="incidence">
            <div id="firstIncidence">
              <label for="responsable" class="form-label">{{__('Responsable')}}</label>
              <select class="form-select form-select mb-3" id="responable[]" name="responsable[]" required>
                <option value="--" selected>{{__('Please select responsable')}}</option>
                @if($owners != false)
                @foreach($owners as $owner)
                <optgroup label="{{$owner->name}}">
                  @foreach($tasks as $task)
                    @if($task->owner == $owner->id)
                      <option value="{{$task->owner}}-{{$task->code}}">{{$task->name}}</option>
                    @endif
                  @endforeach
                </optgroup>
                @endforeach;
                @endif
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
  @endif
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="CallInfo" id="callInfo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CallInfo">{{__('Information Calls')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body m-3">
      @foreach($answer->calls as $call)
        {{$call->call_id}}
      @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dimiss="modal">{{__('Close')}}</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
  $('#addIncidence').click(function(event) {
    $('#firstIncidence').clone().appendTo('#moreIncidence');
  })
});
function showIncidence() {
  $('#incidence').css('visibility','visible');
  $('#workOrder').css('display','block');
  $('#anyIncidence').css('display','none');
  $('#bodyIncidence').css('position','relative');
}
function sendForm() {
  $('#questionary').submit();
}
</script>
@endsection