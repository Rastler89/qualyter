@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-md">
        <div class="form-floating">
            <input id="first_date" min="" max="" type="date" class="form-control filter" name="initial_date" value="{{$first}}"/>
            <label for="init_date">{{__('Initial Date')}}</label>
        </div>
    </div>
    <div class="col-md">
        <div class="form-floating">
            <input id="last_date" min="" type="date" class="form-control filter" name="finish_date" value="{{$last}}"/>
            <label for="finish_date">{{__('Final Date')}}</label>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md mt-1">
      <div class="form-floating">
        <select class="form-select filter" id="type">
          <option value="agent">{{__('Agent')}}</option>
          <option value="teams">{{__('Teams')}}</option>
          <option value="general">{{__('General')}}</option>
        </select>
        <label for="type">{{__('Type')}}</label>
      </div>
  </div>
</div>


@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.filter').on('change',function() {
        limits();
        //carga();
    })
    limits();
    //carga();
});

function limits() {
    $('#first_date').attr('max',$('#last_date').val());
    $('#last_date').attr('min',$('#first_date').val());
}    
</script>
@endsection