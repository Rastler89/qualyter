@extends('layouts.dashboard')

@section('content')
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('Email')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <form method="POST" action="{{route('agents.create')}}">
                @csrf
                <td>
                    <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}"/>
                </td>
                <td>
                    <input type="email" class="form-control" name="email" placeholder="{{__('E-mail')}}"/>
                </td>
                <td>
                    <button class="btn btn-primary">{{__('Add new agent')}}</button>
                </td>
            </form>
        </tr>
        @foreach ($agents as $agent)
            <form method="POST" action="{{route('agents.update', ['id' => $agent->id])}}">
                @csrf
                @method('PUT')
                <tr>
                    <td><input type="text" id="name{{$agent->id}}" class="form-control" name="name" value="{{$agent->name}}" disabled/></td>
                    <td><input type="email" id="email{{$agent->id}}" class="form-control" name="email" value="{{$agent->email}}" disabled/></td>
                    <td>
                        <button class="btn btn-warning" id="editAgent{{$agent->id}}" onclick="editable({{$agent->id}})" type="button">{{__("Edit agent")}}</button>
                        <button class="btn btn-success" id="sendAgent{{$agent->id}}" style="visibility:hidden">{{__("Edit agent")}}</button>
                    </td>
                </tr>
            </form>
        @endforeach
    </tbody>
</table>
{{$agents->links()}}
@endsection

@section('javascript')
<script>
function editable(id) {
    document.getElementById('name'+id).disabled=false;
    document.getElementById('email'+id).disabled=false;
    document.getElementById('editAgent'+id).style.visibility = 'hidden';
    document.getElementById('sendAgent'+id).style.visibility = 'visible';
}
</script>
@endsection