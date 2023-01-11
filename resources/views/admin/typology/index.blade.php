@extends('layouts.dashboard')

@section('content')
<div class="btn-group" role="group">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNew">Add</button>
</div>
<form method="POST" action="{{route('typologies.add')}}">
    @csrf
    <div class="modal fade" id="addNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">{{__("Add new typology")}}</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" class="form-label">{{__("Name")}}</label>
                                <input type="text" class="form-control" name="name" id="name" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                    <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">{{__("Name")}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($typologies as $typology)
        <tr>
            <td>{{$typology->id}}</td>
            <td>{{$typology->name}}</td>
            <td>
                <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modify{{$typology->id}}">{{__("Edit")}}</button>
                <form method="POST" action="{{route('typologies.delete',['id'=>$typology->id])}}">
                    @method('Delete')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">{{__("Delete")}}</button>
                </form>
            </td>
            <form method="POST" action="{{route('typologies.update',['id' => $typology->id])}}">
                @csrf
                <div class="modal fade" id="modify{{$typology->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addNewLabel">{{__("Modify typology")}}</h5>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">{{__("Name")}}</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{$typology->name}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                                <button type="submit" class="btn btn-primary">{{__("Create")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
{{$typologies->links()}}
@endsection