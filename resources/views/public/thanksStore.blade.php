@extends('layouts.public')

@section('sytles')
<link rel="stylesheet" href="{{ asset("css/custom.css") }}">
@endsection
@section('content')
<main class="px-3 text-center">
    <h1>{{__('Thank you for your response')}}</h1>
    <p class="lead">{{__('Thanks to your feedback we improve and offer a better service every day, we hope you have a great day.')}}</p>
    <p class="lead">
    </p>
</main>

@endsection