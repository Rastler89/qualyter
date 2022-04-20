@extends('layouts.dashboard')

@section('styles')

@endsection

@section('content')
<div class="mb-3">
    <h1 class="h3 d-inline align-middle">{{__('Create new WorkOrder')}}</h1>
</div>
<div class="row">
    <form method="POST" action="{{route('workorder.create')}}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">{{__('Code')}}</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{old('code')}}" />
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Name')}}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" />
                    </div>
                    <div class="mb-3">
                        <label for="expiration" class="form-label">{{__('Expiration')}}</label>
                        <input type="datetime-local" id="expiration" class="form-control" name="expiration">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">{{__('Priority')}}</label>
                        <input type="text" class="form-control" id="priority" name="priority" value="{{old('priority')}}" />
                    </div>
                    <div class="mb-3">
                        <label for="owner" class="form-label">{{__('Responsable')}}</label>
                        <input class="form-control" list="owners" id="owner" name="owner" placeholder="{{__('Type to search...')}}" />
                        <datalist id="owners">
                            @foreach($owners as $owner)  
                                <option value="{{$owner->id}}">{{$owner->name}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="store" class="form-label">{{__('Store')}}</label>
                        <input class="form-control" list="stores" id="store" name="store" placeholder="{{__('Type to search...')}}" />
                        <datalist id="stores">
                            @foreach($stores as $store)  
                                <option value="{{$store->code}}">{{$store->name}}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg btn-block">{{__('Create new work order')}}</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')