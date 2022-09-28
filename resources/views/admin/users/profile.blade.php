@extends('layouts.dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-3 col-xl-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{__('Profile Settings')}}</h5>
                </div>
                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
                        {{__('Account')}}
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
                        {{__('Password')}}
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#statistics" role="tab">
                        {{__('Statistics')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{__('Public info')}}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('profile.name')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputUsername">{{__('Username')}}</label>
                                            <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="name" value="{{auth()->user()->name}}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="token">{{__('Token Ringover')}}</label>
                                            <input type="text" class="form-control" id="token" placeholder="TokenCall" name="token" value="{{$user->token}}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">{{__('Phone Number')}}</label>
                                            <input type="phone" class="form-control" id="phone" placeholder="PhoneNumber" name="phone" value="{{$user->phone}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <img alt="Avatar" src="{{asset('/img/avatar.svg')}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
                                            <!--<div class="mt-2">
                                                <span class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
                                            </div>
                                            <small>For best results, use an image at least 128px by 128px in .jpg format</small>-->
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{__('Password')}}</h5>
                            <form method="POST" action="{{route('profile.password')}}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordCurrent">{{__('Current Password')}}</label>
                                    <input type="password" class="form-control" id="inputPasswordCurrent">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordNew">{{__('New Password')}}</label>
                                    <input type="password" class="form-control" id="inputPasswordNew">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="inputPasswordNew2">{{__('Confirm Password')}}</label>
                                    <input type="password" class="form-control" id="inputPasswordNew2">
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="statistics" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{__('Statistics')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Answers Complete Today")}}</h3>
                                    <div class="text-center">{{$data['day_answer']}}</div>
                                </div>
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Incidence Open Today")}}</h3>
                                    <div class="text-center">{{$data['day_open_incidence']}}</div>
                                </div>
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Incidence Closed Today")}}</h3>
                                    <div class="text-center">{{$data['day_close_incidence']}}</div>
                                </div>
                            </div>
                            Total
                            <div class="row">
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Answers Complete Total")}}</h3>
                                    <div class="text-center">{{$data['total_answer']}}</div>
                                </div>
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Incidence Open Total")}}</h3>
                                    <div class="text-center">{{$data['total_open_incidence']}}</div>
                                </div>
                                <div class="col-4">
                                    <h3 style="font-size:0.75em">{{__("Incidence Closed Total")}}</h3>
                                    <div class="text-center">{{$data['total_close_incidence']}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection