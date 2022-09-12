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
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('% incidences Generated')}}</th>
            <th scope="col">{{__('Number of incidences')}}</th>
            <th scope="col">{{__('% Completed')}}</th>
            <th scope="col">{{__('Average Time')}}</th>
            <th scope="col">{{__('% Urgent')}}</th>
            <th scope="col">{{__('% High')}}</th>
            <th scope="col">{{__('% Medium')}}</th>
            <th scope="col">{{__('% Low')}}</th>
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
    $.post('/api/reports/incidences',{init:$('#first_date').val(),finish:$('#last_date').val(),type:$('#type').val() }, function(res) {
        console.log(res);
        var count=0;
        $.each(res, function(index,line) {
            count++;
            if(count%2==0) {
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
            time = '';
            if(line.incidences.average_time.days!=0) {
                time = time + line.incidences.average_time.days + "days ";
            }
            if(line.incidences.average_time.hours!=0) {
                time = time + line.incidences.average_time.hours + "hours ";
            }
            if(line.incidences.average_time.minutes!=0) {
                time = time + line.incidences.average_time.minutes + "minutes ";
            }
            if(time=='') {
                time = '0';
            }
            text=text+'<td class="text-center">'+line.incidences.per_incidences+'</td>';
            text=text+'<td class="text-center">'+line.incidences.num_incidences+'</td>';
            text=text+'<td class="text-center">'+line.incidences.per_completed+'</td>';
            text=text+'<td class="text-center">'+time+'</td>';
            text=text+'<td class="text-center">'+line.incidences.per_urgent+'</td>';
            text=text+'<td class="text-center">'+line.incidences.per_high+'</td>';
            text=text+'<td class="text-center">'+line.incidences.per_medium+'</td>';
            text=text+'<td class="text-center">'+line.incidences.per_low+'</td>';
            text=text+'</tr>';
            $('#bodytable').append(text);
        })
    })
}

</script>
@endsection