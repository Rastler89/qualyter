@extends('layouts.public')

@section('content')
@if($client->father != null)
<a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="align-middle" data-feather="chevron-left"></i></a>
@endif
<h1 class="text-center mb-3">{{$client->name}}</h1>
<div class="row">
    <div class="col-md-4">
        <h5 class="mb-4">{{__("reporting period")}}: {{$first_day}} - {{$last_day}}</h5>
        <?php $partir = explode(".", number_format($client->average,2) ); ?>
        <?php $star = intval($client->average); ?>
        <h2 class="text-center mt-3">{{$client->average}}</h2>
        <p class="text-center">@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-hover.svg') }}" width="60" height="60" />@endfor 
        @if(isset($partir) && $partir[1] >= 5)
                    <img src="{{ asset('img/star-hover-half.svg') }}" width="60" height="60" />
        @endif
        </p>
        <ul class="list-group">
            <li class="list-group-item">{{__("Number of cases in the investigation period")}}: <strong>{{$extra['visits']}} {{__("visits")}}</strong></li>
            <li class="list-group-item">{{__("Number of responses to telephone surveys")}}: <strong>{{$extra['qc']}} {{__("calls")}}</strong></li>
            <li class="list-group-item">{{__("Number of e-mail surveys")}}: <strong>{{$extra['send']}} {{__("surveys sent")}}</strong></li>
            <li class="list-group-item">{{__("Number of responses to email surveys")}}: <strong>{{$extra['resp']}} {{__("surveys answered")}}</strong></li>
            <li class="list-group-item">{{__("Percentage of visits contacted")}}: <strong>{{$extra['per_con']}} %</strong></li>
            <li class="list-group-item">{{__("Response rate")}}: <strong>{{$extra['per_ans']}} %</strong></li>
            <li class="list-group-item">{{__("Total response rate")}}: <strong>{{$extra['tot_ans']}} %</strong></li>
            <li class="list-group-item"><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#notRespond">{{__("View unanswered")}}</button></li>
        </ul>
    </div>
    <div class="col-md-8">
        <div id="counter" class="text-center mb-3"></div>
        <div class="btn-group col-12 mb-1" role="group" aria-label="navigation" id="navigation">
            <button type="button" onclick="prev()" id="previous" class="btn btn-outline-primary" disabled>Previous</button>
            <button type="button" onclick="next()" id="next" class="btn btn-outline-primary">Next</button>
        </div>
        @foreach($answers as $answer)
        <div id="answer{{$loop->iteration}}" class="col-12" style="display:none">
            <div class="card text-center" style="width:auto;margin:auto auto;">
                <div class="card-body">
                    <strong>{{$answer['shop']}}</strong><br/>
                    {{$answer['updated_at']}}<br/>
                    @foreach($answer['workOrders'] as $workOrder)
                    <strong>{{$workOrder->code}}</strong> - {{$workOrder->name}}<br/>
                    @endforeach
                </div>
            </div>
            <?php $respuestas = json_decode($answer['answer'],true); ?>
            <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                {{__('What overall score would you give us?')}}
                </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <?php $star = intval($respuestas['valoration'][0]); ?>
                    <p>{{__('Valoration')}}: <strong>{{$respuestas['valoration'][0]}}</strong></p>
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-hover.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: <br/>@if($respuestas['comment'][0]=='') {{__("NC")}} @else {{$respuestas['comment'][0]}}@endif</p>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                {{__('Rate the speed of our service')}}
                </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <?php $star = intval($respuestas['valoration'][1]); ?>
                    <p>{{__('Valoration')}}: <strong>{{$respuestas['valoration'][1]}}</strong></p>
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-hover.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: <br/>@if($respuestas['comment'][1]=='') {{__("NC")}} @else {{$respuestas['comment'][1]}}@endif</p>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                {{__('Appreciates the friendliness of our technicians')}}
                </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                    <?php $star = intval($respuestas['valoration'][2]); ?>
                    <p>{{__('Valoration')}}: <strong>{{$respuestas['valoration'][2]}}</strong></p>
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-hover.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}:0<br/> @if($respuestas['comment'][2]=='') {{__("NC")}} @else {{$respuestas['comment'][2]}}@endif</p>
                </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-control="panelsStayOpen-collapseFour">
                {{__('Scores the resolution capacity of the incidences')}}
                </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                <div class="accordion-body">
                    <?php $star = intval($respuestas['valoration'][3]); ?>
                    <p>{{__('Valoration')}}: <strong>{{$respuestas['valoration'][3]}}</strong></p>
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-hover.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: <br/>@if($respuestas['comment'][3]=='') {{__("NC")}} @else {{$respuestas['comment'][3]}}@endif</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal not respond -->
<div class="modal fade" id="notRespond" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="notRespondLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notRespondLabel">{{__("Shops not respond")}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>{{__("Code")}}</td>
                            <td>{{__("Name")}}</td>
                            <td>{{__("Not Respond")}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notResponds as $notRespond)
                        <tr>
                            <td>{{$notRespond->code}}</td>
                            <td>{{$notRespond->name}}</td>
                            <td>{{$notRespond->total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const MAX = {{$total}};
    var page = 1;

    $(document).ready(function() {
        if(MAX==1) {
            $('#navigation').css('visibility','hidden');
        }
        print();
        
    });

    function prev() {
        page = page -1;
        print();
        state();
    }

    function next() {
        page = page + 1;
        print();
        state();
    }

    function print() {
        if(MAX>1) {
            text = "{{__('Answers')}}: "+page + ' {{__("of")}} ' + MAX;
            $('#counter').text(text);
        }
        show();
    }

    function state() {
        if(page<=MAX && page >1) {
            $('#previous').prop('disabled',false);
        } else {
            $('#previous').prop('disabled',true);
        }
        if(page<MAX && page>0) {
            $('#next').prop('disabled',false);
        } else {
            $('#next').prop('disabled',true);
        }
    }

    function show() {
        for(i=1; i<=MAX; i++) {
            if(page==i) {
                $('#answer'+i).css('display','block');
            } else {
                $('#answer'+i).css('display','none');
            }
        }
    }

</script>
@endsection