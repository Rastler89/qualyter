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
            <p><strong>{{__('Expiration')}}</strong></p>
            <p>{{$answer->expiration}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-4 col-sm-4">
    <div class="accordion" id="workOrder" style="position:sticky;">
      @foreach($answer->answer['valoration'] as $ans)
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
            aaa
          </button>
        </h2>
        <div id="collapse{{$loop->index}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#workOrder">
          <div class="accordion-body">
            <p>b</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection