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
    $('.filter').on('change',function() {
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
  $('#bodytable').empty();
  $.post('/api/leaderboard',{init:$('#first_date').val(),finish:$('#last_date').val(),type:$('#type').val() }, function(res) {
    $.each(res, function(index,line) {
      if(index%2==0) {
        text='<tr class="table-light">';
      } else {
        text='<tr class="table-primary">'
      }
      switch($('#type').val()) {
        case 'agent':
          text=text+'<td>'+line.agent.name+'</td>';
          break;
        case 'teams':
          text=text+'<td>'+line.team+'</td>';
          break;
        case 'general':
          text=text+'<td>Optima Retail</td>';
          break;
      } 
      text=text+'<td class="text-center">'+parseFloat(line[0]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[1]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[2]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+parseFloat(line[3]).toFixed(2)+'</td>';
      text=text+'<td class="text-center">'+line.total+'</td>'
      text=text+'</tr>';

      $('#bodytable').append(text);
    })
  })
}
</script>
@endsection