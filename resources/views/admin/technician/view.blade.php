@extends('layouts.dashboard')
<?php
 $array = json_decode($technician->services,true);
 foreach($array as $key => $value) {
     if(gettype($value)=='array') {
         $array[$key]=$value['other'];
     }
 }
 $technician->services = $array;
 $workers = json_decode($technician->info_workers,true);
?>
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body m-sm-3 m-md-5">
                <div class="mb-4">
                    <strong>{{$technician->company}}</strong> - {{$technician->nif}}
                    <br />
                    {{__("Contact")}}: <strong>{{$technician->contact}}</strong>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Country')}}</div>
                        <strong>{{$technician->country}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Region')}}</div>
                        <strong>{{$technician->region}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Town')}}</div>
                        <strong>{{$technician->town}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Address')}}</div>
                        <strong>{{$technician->address}}</strong>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-muted">{{__('Main phone')}}</div>
                        <strong>{{$technician->main_phone}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('Administration phone')}}</div>
                        <strong>{{$technician->admin_phone}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('24h phone')}}</div>
                        <strong>{{$technician->all_phone}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('Main email')}}</div>
                        <strong>{{$technician->main_email}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('Administration email')}}</div>
                        <strong>{{$technician->admin_email}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('24h email')}}</div>
                        <strong>{{$technician->all_email}}</strong>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-muted">{{__('Services')}}</div>
                        <strong>
                        @foreach($technician->services as $service)
                            {{$service}}
                        @endforeach
                        </strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">{{__('Area')}}</div>
                        <strong>{{$technician->area}}</strong>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Travel')}}</div>
                        <strong>{{$technician->travel}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Urgent trip')}}</div>
                        <strong>{{$technician->travel_ah}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('Hour')}}</div>
                        <strong>{{$technician->hour}}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted">{{__('After hour')}}</div>
                        <strong>{{$technician->hour_ah}}</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">{{__('Type of payment')}}</div>
                        <strong>{{$technician->type_payment}}</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted">{{__('IBAN')}}</div>
                        <strong>{{$technician->iban}}</strong>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-muted">{{__('Nº of employees')}}</div>
                        <strong>{{$technician->workers}}</strong>
                    </div>
                    @foreach($workers as $worker)
                    <div class="col-md-4">
                        <div class="text-muted">{{__("Name")}}</div>
                        <strong>{{$worker['name']}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__("NIF")}}</div>
                        <strong>{{$worker['nif']}}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted">{{__('Files')}}</div>
                        <ul>
                            <li><a target="_blank" href={{ asset('uploads/'.$worker['ppe']) }}>{{__('PPE')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$worker['art18']) }}>{{__('Art18')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$worker['art19']) }}>{{__('Art19')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$worker['medical']) }}>{{__('Medical')}}</a></li>
                        </ul>
                    </div>
                    @endforeach
                </div>
                <hr class="my-4" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-muted">{{__("PRL")}}</div>
                        <ul>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->risk) }}>{{__('Risk')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->preventive) }}>{{__('Preventive')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->certificate_pay) }}>{{__('Certificate Payment')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->rnt) }}>{{__('RNT')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->rlc) }}>{{__('RLC')}}</a></li>
                            <li><a target="_blank" href={{ asset('uploads/'.$technician->tax) }}>{{__('Tax')}}</a></li>
                        </ul>
                    </div>
                </div>
                <!--<div class="text-center">
                    <p class="text-sm">
                        <strong>Extra note:</strong>
                        Please send all items at the same time to the shipping address.
                        Thanks in advance.
                    </p>

                    <a target="_blank" href="#" class="btn btn-primary">
                        Print this receipt
                    </a>
                </div>-->
            </div>
        </div>
    </div>
</div>
@endsection