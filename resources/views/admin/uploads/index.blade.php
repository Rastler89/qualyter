@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{__('Tasks')}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('uploads.tasks')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">{{__('To bulk upload task data')}}</label>
                        <input class="form-control" type="file" id="file" name="file" />
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success" >{{__("Upload File")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{__('Agents')}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('uploads.agents')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">{{__('To bulk upload agent data')}}</label>
                        <input class="form-control" type="file" id="file" name="file" />
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success" >{{__("Upload File")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{__('Stores')}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('uploads.stores')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">{{__('To bulk upload store data')}}</label>
                        <input class="form-control" type="file" id="file" name="file" />
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success">{{__("Upload File")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{__('Clients')}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('uploads.clients')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">{{__('To bulk upload client data')}}</label>
                        <input class="form-control" type="file" id="file" name="file" />
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success">{{__("Upload File")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection