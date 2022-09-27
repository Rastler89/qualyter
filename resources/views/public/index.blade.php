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
    $mon_name = $month;
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
    print_r($mon_name);
?>

@section('content')
<h3 class="text-center mb-3">{{__('Month: :month',['month'=>$month])}}</h3>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4 mb">
                <label for="month" class="form-label">{{__('Month')}}</label>
                <select class="form-select" name="month" id="month">
                    <option value="1" @if($mon_name==1) selected @endif>{{__('January')}}</option>
                    <option value="2" @if($mon_name==2) selected @endif>{{__('February')}}</option>
                    <option value="3" @if($mon_name==3) selected @endif>{{__('March')}}</option>
                    <option value="4" @if($mon_name==4) selected @endif>{{__('April')}}</option>
                    <option value="5" @if($mon_name==5) selected @endif>{{__('May')}}</option>
                    <option value="6" @if($mon_name==6) selected @endif>{{__('June')}}</option>
                    <option value="7" @if($mon_name==7) selected @endif>{{__('July')}}</option>
                    <option value="8" @if($mon_name==8) selected @endif>{{__('August')}}</option>
                    <option value="9" @if($mon_name==9) selected @endif>{{__('September')}}</option>
                    <option value="10" @if($mon_name==10) selected @endif>{{__('October')}}</option>
                    <option value="11" @if($mon_name==11) selected @endif>{{__('November')}}</option>
                    <option value="0" @if($mon_name==0) selected @endif>{{__('February')}}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="year" class="form-label">{{__('Year')}}</label>
                <select class="form-select" name="year" id="year">
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    @foreach($delegations as $delegation)
    <div class="col-md-{{$size}}">
        <div class="card text-center">
            <div class="card-header">
            {{$delegation->name}}
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h4><?= number_format($delegation['average'],2)?></h4>
                    <?php $star = intval($delegation['average']); ?>
                @for($i=0; $i <$star; $i++)
                    <img src="{{ asset('img/star-hover.svg') }}" width="30" height="30" />
                @endfor
                </div>
                <p class="card-text">
                    {{$delegation['visits']}} {{__("surveys conducted")}}
                </p>
            </div>
            <div class="card-footer text-muted">
            <a class="btn btn-outline-primary" href="{{route('public.detail', ['central' => $central->id, 'delegation' => $delegation->id])}}">{{__("View more")}}</a>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection