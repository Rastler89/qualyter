@extends('layouts.dashboard')

@section('content')
<div class="mb-3">
    <h1 class="h3 d-inline align-middle">@if ($client != null) {{__('Edit Client')}} @else {{__('Add new client')}} @endif </h1>
</div>
<div class="row">
    <form method="POST" action="@if ($client != null) {{route('clients.update', ['id' => $client->id])}} @else {{route('clients.create')}} @endif">
        @if ($client != null) 
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
                        <label for="name" class="form-label">{{__('Name')}} <span style="font-size: 0.75em; color: red">{{__("Is public")}}</span></label>
                        <input type="text" class="form-control" id="name" name="name" @if ($client != null) value="{{$client->name}}" @endif/>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">{{__('Country')}}</label>
                        <input class="form-control" list="countries" @if($client!=null) value="--" @endif id="country" name="country" placeholder="{{__('Type to search...')}}" >
                        <datalist id="countries"></datalist>
                    </div>
                    <div class="mb-3">
                        <label for="phonenumber" class="form-label">{{__("Phone Number")}}</label>
                        <input class="form-control" id="phonenumber" name="phonenumber" type="text" @if ($client != null) value="{{$client->phonenumber}}" @endif/>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{__("Email")}}</label>
                        <textarea class="form-control" id="email" name="email" row="3">@if ($client != null) {{$client->email}} @endif</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="father" class="form-label">{{__('Father')}}</label>
                        <input class="form-control" list="fathers" id="father" name="father" placeholder="{{__('Type to search...')}}" @if($client != null) value="{{$client->father}}" @endif />
                        <datalist id="fathers">
                            <option value="--">{{__('Nothing')}}</option>
                            @foreach($clients as $father)  
                                <option value="{{$father->id}}">{{$father->name}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="central" name="central" @if($client != null && $client->delegation === '00') checked @endif />
                            <span class="form-check-label">{{__('This client is central')}}</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="extra" name="extra" @if($client != null) @if($client->extra) checked @endif @endif />
                            <span class="form-check-label">{{__('Extra information')}}</span>
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
        $("#countries").append("<option value='00'> Central </option>");
        data.forEach(function(country,index) {
            $("#countries").append("<option value='"+country['name']+"'>"+country['translations'][lang[0]]+"</option>");
        });
    });
</script>
@endsection