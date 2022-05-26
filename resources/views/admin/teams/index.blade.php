<?php 

foreach($managers as $manager) {
    foreach($teams as &$team) {
        if($team->manager == $manager->id) {
            $team->manager = $team->manager.' - '.$manager->name;
        }
    }
}

?>

@extends('layouts.dashboard')

@section('content')
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__("Name")}}</th>
            <th scope="col">{{__("Short Name")}}</th>
            <th scope="col">{{__("Manager")}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form method="POST" action="{{route('team.create')}}">
                @csrf
                <td>
                    <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}"/>
                </td>
                <td>
                    <input type="text" class="form-control" name="url" placeholder="{{__('Url')}}"/>
                </td>
                <td>
                    <input class="form-control" list="managers" id="manager" name="manager" placeholder="{{__('Type to search...')}}" />
                    <datalist id="managers">
                        @foreach($managers as $manager)  
                            <option value="{{$manager->id}} - {{$manager->name}}">{{$manager->name}}</option>
                        @endforeach
                    </datalist>
                </td>
                <td>
                    <button class="btn btn-primary">{{__("Add new team")}}</button>
                </td>
            </form>
        </tr>
        @foreach($teams as $team)
            <form method="POST" action="{{route('team.update',['id' => $team->id])}}">
            @csrf
            @method('PUT')
            <tr>
                <td>
                    <input value="{{$team->name}}" type="text" class="form-control" name="name" id="name{{$team->id}}" placeholder="{{__('Name')}}" disabled/>
                </td>
                <td>
                    <input value="{{$team->url}}" type="text" class="form-control" name="url" id="url{{$team->id}}" placeholder="{{__('Url')}}" disabled/>
                </td>
                <td>
                    <input value="{{$team->manager}}" class="form-control" list="managers" name="manager" id="manager{{$team->id}}" placeholder="{{__('Type to search...')}}" disabled/>
                    <datalist id="managers">
                        @foreach($managers as $manager)  
                            <option value="{{$manager->id}} - {{$manager->name}}" >{{$manager->name}}</option>
                        @endforeach
                    </datalist>
                </td>
                <td>
                    <button class="btn btn-warning" id="editTeam{{$team->id}}" onclick="editable({{$team->id}})" type="button">{{__("Edit team")}}</button>
                    <button class="btn btn-success" id="sendTeam{{$team->id}}" style="visibility:hidden">{{__("Save team")}}</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('javascript')
<script>
function editable(id) {
    document.getElementById('name'+id).disabled=false;
    document.getElementById('url'+id).disabled=false;
    document.getElementById('manager'+id).disabled=false;
    document.getElementById('editTeam'+id).style.visibility = 'hidden';
    document.getElementById('sendTeam'+id).style.visibility = 'visible';
}
</script>
@endsection