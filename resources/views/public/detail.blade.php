@extends('layouts.public')

@section('content')
<h1 class="text-center mb-3">{{$client->name}}</h1>
<div class="row">
    <div class="col-md-4">
        <h5 class="mb-4">{{__("periodo de información")}}: {{$first_day}} - {{$last_day}}</h5>
        <ul class="list-group">
            <li class="list-group-item">{{__("Number of cases in the investigation period")}}: <strong>{{$extra['visits']}} {{__("visits")}}</strong></li>
            <li class="list-group-item">{{__("Number of responses to telephone surveys")}}: <strong>{{$extra['qc']}} {{__("calls")}}</strong></li>
            <li class="list-group-item">{{__("Number of e-mail surveys")}}: <strong>{{$extra['send']}} {{__("surveys sent")}}</strong></li>
            <li class="list-group-item">{{__("Number of responses to email surveys")}}: <strong>{{$extra['resp']}} {{__("surveys answered")}}</strong></li>
        </ul>
    </div>
    <div class="col-md-8">
        <div id="counter" class="text-center"></div>
        <div class="btn-group col-12" role="group" aria-label="navigation" id="navigation">
            <button type="button" onclick="prev()" id="previous" class="btn btn-outline-primary" disabled>Previous</button>
            <button type="button" onclick="next()" id="next" class="btn btn-outline-primary">Next</button>
        </div>
        @foreach($answers as $answer)
        <div id="answer{{$loop->iteration}}" class="col-12" style="display:none">
            <div class="card text-center" style="width:auto;margin:auto auto;">
                <div class="card-body">
                    <strong>{{$answer['shop']}}</strong>
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
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-selected.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: {{$respuestas['comment'][0]}}</p>
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
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-selected.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: {{$respuestas['comment'][1]}}</p>
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
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-selected.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: {{$respuestas['comment'][2]}}</p>
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
                    <p>@for($i=0; $i <$star; $i++)<img src="{{ asset('img/star-selected.svg') }}" width="50" height="50" />@endfor</p>
                    <p>{{__('Comments')}}: {{$respuestas['comment'][3]}}</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        @endforeach
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