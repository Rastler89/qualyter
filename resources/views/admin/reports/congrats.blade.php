@extends('layouts.dashboard')

@section('content')
<div class="btn-group mb-3" role="group" aria-label="botonera">
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addCongratulation"><i class="align-middle" data-feather="plus"></i></button>
</div>

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
            <th scope="col">{{__('Total')}}</th>
            <th scope="col">{{__('%')}}</th>
        </tr>
    </thead>
    <tbody id='bodytable'></tbody>
</table>

<form method="POST" action="{{route('congratulation.new')}}">
    @csrf
<div class="modal fade" id="addCongratulation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCongratulation" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="agent" class="form-label">{{__('Agent')}}</label>
                            <input class="form-control" list="agents" id="agent" name="agent" placeholder="{{__('Type to search...')}}" />
                            <datalist id="agents">
                                @foreach($agents as $agent)  
                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="client" class="form-label">{{__('Client')}}</label>
                            <input class="form-control" list="clients" id="client" name="client" placeholder="{{__('Type to search...')}}" />
                            <datalist id="clients">
                                @foreach($clients as $client)  
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
            </div>
        </div>
    </div>
</div>
</form>

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
    $.post('/api/reports/congratulations',{init:$('#first_date').val(),finish:$('#last_date').val(),type:$('#type').val() }, function(res) {
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
            text=text+'<td class="text-center">'+line.total+'</td>';
            text=text+'<td class="text-center">'+line.percentage+'</td>';
            text=text+'</tr>';
            $('#bodytable').append(text);
        })
    })
}

</script>
@endsection