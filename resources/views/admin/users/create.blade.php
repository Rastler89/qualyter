@extends('layouts.dashboard')

@section('content')
<div class="mb-3">
    <h1 class="h3 d-inline align-middle">{{__('Create New User')}}</h1>
</div>
<div class="row">
    <form method="POST" action="{{route('users.create')}}">
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
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Profile')}}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Name')}}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{__('Email address')}}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{__('Password')}}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="*****" />
                    </div>
                    <div class="mb-3">
                        <label for="password-confirmation" class="form-label">{{__('Repeat Password')}}</label>
                        <input type="password" class="form-control" id="re-password" name="password-confirmation" placeholder="*****" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Role')}}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <select id="role" name="role" class="form-select">
                            <option value="---">{{__('No Role')}}
                                @foreach ($roles as $role)
                                    <option value="{{$role->slug}}">{{$role->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-success">{{__('Create User')}}</button>
        </div>
    </form>
</div>
@endsection