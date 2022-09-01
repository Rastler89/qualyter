@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-md">
        <div class="form-floating">
            <input id="first_date" min="" max="" type="date" class="form-control dates" name="initial_date" value="{{$first}}"/>
            <label for="init_date">{{__('Initial Date')}}</label>
        </div>
    </div>
    <div class="col-md">
        <div class="form-floating">
            <input id="last_date" min="" type="date" class="form-control dates" name="finish_date" value="{{$last}}"/>
            <label for="finish_date">{{__('Final Date')}}</label>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md mt-1">
      <div class="form-floating">
        <select class="form-select" id="type">
          <option value="agent">{{__('Agent')}}</option>
          <option value="teams">{{__('Teams')}}</option>
        </select>
        <label for="type">{{__('Type')}}</label>
      </div>
  </div>
</div>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">{{__('Agent')}}</th>
      <th scope="col">{{__("Question 1")}}</th>
      <th scope="col">{{__("Question 2")}}</th>
      <th scope="col">{{__("Question 3")}}</th>
      <th scope="col">{{__("Question 4")}}</th>
      <th scope="col">{{__('Total answers')}}</th>
    </tr>
  </thead>
  <tbody id='bodytable'></tbody>
</table>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('.dates').on('change',function() {
        limits();
        carga();
    })
    limits();
    carga();
});

function limits() {
    $('#first_date').attr('max',$('#last_date').val());
    $('#last_date').attr('min',$('#first_date').val());
}
function carga() {
  console.log('limpiando');
  $('#bodytable').empty();
  console.log('limpio');
  $.post('/api/leaderboard',{init:$('#first_date').val(),finish:$('#last_date').val() }, function(res) {
    $.each(res, function(index,line) {
      if(index%2==0) {
        text='<tr class="table-light">';
      } else {
        text='<tr class="table-primary">'
      }
      text=text+'<td>'+line.agent.name+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[0]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[1]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[2]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[3]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+line.total+'</td></tr>';

      $('#bodytable').append(text);
    })
  })
}
</script>
@endsection