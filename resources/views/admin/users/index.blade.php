@extends('layouts.dashboard')

@section('content')
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a class="btn btn-success" href="{{route('users.new')}}">{{__('New User')}}</a>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col">{{__('E-Mail')}}</th>
            <th scope="col">{{__('Roles')}}</th>
            @can('edit-users')
            <th scope="col">{{__('Access')}}</th>
            <th scope="col"></th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <form action="{{route('users.edit')}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$user->id}}" />
            <tr>
                <td>
                    <input type="text" value="{{$user->name}}" name="name" id="name{{$user->id}}" class="form-control" disabled/>
                </td>
                <td>
                    <input type="text" value="{{$user->email}}" name="email" id="email{{$user->id}}" class="form-control" disabled/>
                </td>
                <td>
                    <select name="role" class="form-select" id="role{{$user->id}}" disabled>
                        <option value="---"@if(count($user->roles)==0) selected @endif>{{__('No Role')}}</option>
                        @foreach($roles as $role)
                            @if(count($user->roles)==0)
                                <option value="{{$role->slug}}">{{$role->name}}</option>
                            @else 
                                @foreach ($user->roles as $user_role) 
                                <option value="{{$role->slug}}" @if($user_role->slug == $role->slug) selected @endif>{{$role->name}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </td>
                @can('edit-users')
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="status" type="checkbox" id="status{{$user->id}}" @if ($user->status == 1) checked @endif disabled>
                    </div>
                </td>
                <td>
                    <button class="btn btn-warning" id="editUser{{$user->id}}" onclick="editable({{$user->id}})" type="button">{{__("Edit user")}}</button>
                    <button class="btn btn-success" id="sendUser{{$user->id}}" onclick="editable({{$user->id}})" style="visibility:hidden">{{__("Edit user")}}</button>
                </td>
                @endcan
            </tr>
        </form>
        @endforeach
    </tbody>
</table>
@endsection

@section('javascript')
<script>
function editable(id) {
    document.getElementById('name'+id).disabled=false;
    document.getElementById('email'+id).disabled=false;
    document.getElementById('role'+id).disabled=false;
    document.getElementById('status'+id).disabled=false;
    document.getElementById('editUser'+id).style.visibility = 'hidden';
    document.getElementById('sendUser'+id).style.visibility = 'visible';
}
</script>
@endsection