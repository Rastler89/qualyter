@extends('layouts.dashboard')

@section('content')
<?php if($store != null) {
    $code = str_replace('/','_',$store->code); 
    $default = $store->client;
    $contact = $store->contact;
    $whatsapp = $store->whatsapp;
}  else {
    $default = 0;
    $contact = false;
    $whatsapp = false;
}
?>
<div class="mb-3">
    <h1 class="h3 d-inline align-middle">@if ($store != null) {{__('Edit Store')}} @else {{__('Create new Store')}}@endif</h1>
</div>
<div class="row">
    <form method="POST" action="@if ($store != null) {{route('stores.update', ['id' => $code])}} @else {{route('stores.create')}} @endif">
        @if ($store!=null)
            @method('PUT')
        @endif
        @csrf
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">{{__('Code')}}</label>
                        <input type="text" class="form-control" name="code" id="code" maxlength="10" @if ($store!=null) value="{{$store->code}}" @endif />
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Name')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
                        <input type="text" class="form-control" name="name" id="name" @if ($store!=null) value="{{$store->name}}" @endif/>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" @if($store!=null) @if($store->status==1) checked @endif @endif />
                        <label class="form-check-label" for="status">{{__('Open Shop')}}</label>
                    </div>
                    <div class="mb-3">
                        <label for="phonenumber" class="form-label">{{__('Phone Number')}}</label>
                        <input type="text" class="form-control" name="phonenumber" id="phonenumber" @if($store!=null) value="{{$store->phonenumber}}" @endif />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{__("Email")}}</label>
                        <textarea class="form-control" id="email" name="email" row="3">@if ($store != null) {{$store->email}} @endif</textarea>
                    </div>
                    @if($store != null)
                        @if($store->language != null) 
                        <div class="mb-3">
                            <label for="language" class="form-label"><strong>{{__("Language")}}:</strong>{{$store->language}}</label>
                        </div>
                        @endif
                    @endif
                    <div class="mb-3">
                        <label for="country" class="form-label">{{__('Country')}}</label>
                        <input class="form-control" list="countries" @if($store!=null) value="--" @endif id="country" name="country" placeholder="{{__('Type to search...')}}" />
                        <datalist id="countries"></datalist>
                    </div>
                    <div class="mb-3">
                        <label for="client" class="form-label">{{__('Client')}}</label>
                        <input class="form-control" value="{{$default}}" list="clients" id="client" name="client" placeholder="{{__('Type to search...')}}" />
                        <datalist id="clients">
                            @foreach($clients as $client)  
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="contact" name="contact" @if ($contact) checked @endif/>
                            <span class="form-check-label">{{__('This store can contact')}}</span>
                        </label>
                    </div>
                    <div class="mb-3" id="divwhatsapp">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp" @if ($whatsapp) checked @endif/>
                            <span class="form-check-label">{{__('WhatsAspp is available')}}</span>
                        </label>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var userLang = navigator.language || navigator.userLanguage; 
    var lang = userLang.split('-');
    $.get("https://restcountries.com/v2/all", function (data) {
        data.forEach(function(country,index) {
            $("#countries").append("<option value='"+country['name']+"'>"+country['translations'][lang[0]]+"</option>");
        });
    });
    $( document ).ready(function() {
        var status =  $("#contact").is(':checked')
        if(!status) {
            $("#divwhatsapp").hide();
        }
    });

    $("#contact").change(function(){
        var status =  $("#contact").is(':checked')
        if(status) {
            $("#divwhatsapp").show();
        }else {
            $("#divwhatsapp").hide();
        }
    });

</script>
@endsection