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
Account
</a>
<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
Password
</a>
</div>
</div>
</div>

<div class="col-md-9 col-xl-10">
<div class="tab-content">
<div class="tab-pane fade show active" id="account" role="tabpanel">

<div class="card">
<div class="card-header">

<h5 class="card-title mb-0">Public info</h5>
</div>
<div class="card-body">
<form>
<div class="row">
<div class="col-md-8">
<div class="mb-3">
<label class="form-label" for="inputUsername">Username</label>
<input type="text" class="form-control" id="inputUsername" placeholder="Username">
</div>
<div class="mb-3">
<label class="form-label" for="inputUsername">Biography</label>
<textarea rows="2" class="form-control" id="inputBio"
placeholder="Tell something about yourself"></textarea>
</div>
</div>
<div class="col-md-4">
<div class="text-center">
<img alt="Avatar" src="{{asset('/img/avatar.svg')}}" class="rounded-circle img-responsive mt-2"
width="128" height="128" />
<!--<div class="mt-2">
<span class="btn btn-primary"><i class="fas fa-upload"></i> Upload</span>
</div>
<small>For best results, use an image at least 128px by 128px in .jpg format</small>-->
</div>
</div>
</div>

<button type="submit" class="btn btn-primary">Save changes</button>
</form>

</div>
</div>

</div>
<div class="tab-pane fade" id="password" role="tabpanel">
<div class="card">
<div class="card-body">
<h5 class="card-title">Password</h5>

<form>
<div class="mb-3">
<label class="form-label" for="inputPasswordCurrent">Current password</label>
<input type="password" class="form-control" id="inputPasswordCurrent">
<small><a href="#">Forgot your password?</a></small>
</div>
<div class="mb-3">
<label class="form-label" for="inputPasswordNew">New password</label>
<input type="password" class="form-control" id="inputPasswordNew">
</div>
<div class="mb-3">
<label class="form-label" for="inputPasswordNew2">Verify password</label>
<input type="password" class="form-control" id="inputPasswordNew2">
</div>
<button type="submit" class="btn btn-primary">Save changes</button>
</form>

</div>
</div>
</div>
</div>
</div>
</div>

</div>
@endsection