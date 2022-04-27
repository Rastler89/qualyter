@extends('layouts.public')

@section('sytles')
<link rel="stylesheet" href="{{ asset("css/custom.css") }}">
@endsection
@section('content')
<main class="px-3 text-center">
    <h1>{{__('Thank you for your response')}}</h1>
    <p class="lead">{{__('Thank you for attending to the incident, we have notified quality, you will receive a reply shortly. Have a nice day')}}</p>
    <p class="lead">
    </p>
</main>

@endsection