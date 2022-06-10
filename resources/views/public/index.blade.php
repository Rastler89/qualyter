@extends('layouts.public')

@section('sytles')
<link rel="stylesheet" href="{{ asset('css/public.css') }}">
@endsection


<?php 
    if($type=='delegation') {
        switch(count($delegations)) {
            case 0:
            case 1: $size = 12; break;
            case 2: $size = 6; break;
            case 3: $size = 4; break;
            case 4:
            default: $size = 3; break;
        }
    }
    switch($month) {
        case 0: $month = __('December'); break;
        case 1: $month = __('January'); break;
        case 2: $month = __('February'); break;
        case 3: $month = __('March'); break;
        case 4: $month = __('April'); break;
        case 5: $month = __('May'); break;
        case 6: $month = __('June'); break;
        case 7: $month = __('July'); break;
        case 8: $month = __('August'); break;
        case 9: $month = __('September'); break;
        case 10: $month = __('October'); break;
        case 11: $month = __('November'); break;
    }
?>

@section('content')
<h3 class="text-center mb-3">{{__('Month: :month',['month'=>$month])}}</h3>
<div class="row">
    @foreach($delegations as $delegation)
    <div class="col-md-{{$size}}">
        <div class="card text-center">
            <div class="card-header">
            {{$delegation->name}}
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h4>{{$delegation['average']}}</h4>
                    <?php $star = intval($delegation['average']); ?>
                @for($i=0; $i <$star; $i++)
                    <img src="{{ asset('img/star-hover.svg') }}" width="30" height="30" />
                @endfor
                </div>
                <p class="card-text">
                    {{$delegation['visits']}} encuestas realizadas
                </p>
            </div>
            <div class="card-footer text-muted">
            <a class="btn btn-outline-primary" href="{{route('public.detail', ['central' => $central->id, 'delegation' => $delegation->id])}}">Ver Mas</a>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection