@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
    <a class="btn btn-primary" href="{{route('stores.new')}}">{{__('Add Store')}}</a>
</div>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                {{__('Filters')}}
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form class="form-inline" method="GET">
                    <div class="mb-3">
                        <label for="store" class="form-label">{{__('Store`s Code')}}</label>
                        <input type="text" class="form-control" name="code" placeholder="{{__('Store`s Code')}}"/>
                    </div>
                    <div class="mb-3">
                        <label for="client" class="form-label">{{__('Store`s Name')}}</label>
                        <input type="text" class="form-control" name="name" placeholder="{{__('Store`s Name')}}"/>
                    </div>
                    <button class="btn btn-danger">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">@sortablelink('code',__('Code'))</th>
            <th scope="col">@sortablelink('client',__('Name'))</th>
            <th scope="col">{{__('Phone Number')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($stores as $store)
        <?php $code = str_replace('/','_',$store->code); ?>
        <tr>
            <td>{{$store->code}}</td>
            <td>{{$store->name}}</td>
            <td>{{$store->phonenumber}}</td>
            <td>{{$store->email}}</td>
            <td><a href="{{route('stores.edit',['id'=>$code])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$stores->links()}}
@endsection