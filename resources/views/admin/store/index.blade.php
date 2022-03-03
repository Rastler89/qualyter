@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('stores.new')}}">{{__('Add Store')}}</a>
</div>
stores
@endsection