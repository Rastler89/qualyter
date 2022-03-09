@extends('layouts.dashboard')

@section('content')
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
                        <a href="tel:+@if($store->language=='ES' || $store->language==null || $store->language==' ') 34 @endif 617370097">617370097</a>
                    </div>
                </div>
            </div>
          </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="accordion" id="accordionExample">
            <?php $tasks = json_decode($answer->tasks); ?>
            @foreach($tasks as $task)
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                  {{$task->code}} {{$task->name}}
                </button>
              </h2>
              <div id="collapse{{$loop->index}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <p><strong>@foreach($agents as $agent) @if($agent->id==$task->owner) {{$agent->name}} @endif @endforeach</strong></p>
                  <p>{{$task->priority}}</p>
                  <p>{!!html_entity_decode($task->description)!!}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
    </div>
    <div class="col-8">
        <form>
            <fieldset disabled>
              <legend>Disabled fieldset example</legend>
              <div class="mb-3">
                <label for="disabledTextInput" class="form-label">Disabled input</label>
                <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
              </div>
              <div class="mb-3">
                <label for="disabledSelect" class="form-label">Disabled select menu</label>
                <select id="disabledSelect" class="form-select">
                  <option>Disabled select</option>
                </select>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck" disabled>
                  <label class="form-check-label" for="disabledFieldsetCheck">
                    Can't check this
                  </label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </fieldset>
          </form>
    </div>
</div>
@endsection