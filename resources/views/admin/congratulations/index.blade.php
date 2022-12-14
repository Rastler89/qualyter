@extends('layouts.dashboard')

@section('content')
<div class="btn-group" role="group" aria-label="Basic outlined example">
  <!--<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filters"><i class="align-middle" data-feather="filter"></i></button>-->
  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addCongratulation"><i class="align-middle" data-feather="plus"></i></button>
</div>
<table class="table table-hover table-striped">
    <thead>
        <th scope="col">@sortablelink('client',__('Client'))</th>
        <th scope="col">@sortablelink('agent',__('Agent'))</th>
        <th scope="col">@sortablelink('weight',__('Weight'))</th>
        <th scope="col">{{__("Comment")}}</th>
        <th scope="col">@sortablelink('created_at',__("Created"))</th>
        <th scope="col"></th>
    </thead>
    <tbody>
        @foreach($congratulations as $congratulation)
            <tr>
                <td>{{$congratulation->client_name}}</td>
                <td>{{$congratulation->agent_name}}</td>
                <td>{{$congratulation->weight}}</td>
                <td>{{$congratulation->comments}}</td>
                <td>{{$congratulation->created_at}}</td>
                <td><button type="button" onclick="refill({{$congratulation}})" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editCongratulation"><i class="align-middle" data-feather="edit"></i></button></td>
            </tr>
        @endforeach
    </tbody>
</table>

<form method="POST" action="{{route('congratulation.new')}}">
    @csrf
<div class="modal fade" id="addCongratulation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCongratulation" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="agent" class="form-label">{{__('Agent')}}</label>
                            <input class="form-control" list="agents" id="agent" name="agent" placeholder="{{__('Type to search...')}}" />
                            <datalist id="agents">
                                @foreach($agents as $agent)  
                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="client" class="form-label">{{__('Client')}}</label>
                            <input class="form-control" list="clients" id="client" name="client" placeholder="{{__('Type to search...')}}" />
                            <datalist id="clients">
                                @foreach($clients as $client)  
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="weight" class="form-label">{{__('Weight')}}</label>
                            <input class="form-control" type="number" id="weight" name="weight" min="1" step="1" />
                        </div>
                        <div class="col-md-6">
                            <label for="comments">{{__('Comments')}}</label>
                            <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
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

<form method="POST" action="{{route('congratulation.edit')}}">
    @csrf
    <input type="hidden" name="id" id="edit_id"/>
<div class="modal fade" id="editCongratulation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCongratulation" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="agent" class="form-label">{{__('Agent')}}</label>
                            <input class="form-control" list="agents" id="edit_agent" name="agent" placeholder="{{__('Type to search...')}}" />
                            <datalist id="agents">
                                @foreach($agents as $agent)  
                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="client" class="form-label">{{__('Client')}}</label>
                            <input class="form-control" list="clients" id="edit_client" name="client" placeholder="{{__('Type to search...')}}" />
                            <datalist id="clients">
                                @foreach($clients as $client)  
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="weight" class="form-label">{{__('Weight')}}</label>
                            <input class="form-control" type="number" id="edit_weight" name="weight" min="1" step="1" />
                        </div>
                        <div class="col-md-6">
                            <label for="comments">{{__('Comments')}}</label>
                            <textarea class="form-control" id="edit_comments" name="comments" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
            </div>
        </div>
    </div>
</div>
</form>
{{$congratulations->appends([])->links()}}
@endsection

@section('javascript')
<script>
function refill($cong) {
    $("#edit_id").val($cong['id']);
    $("#edit_agent").val($cong['agent']);
    $("#edit_client").val($cong['client']);
    $("#edit_weight").val($cong['weight']);
    $("#edit_comments").val($cong['comments']);
}
</script>
@endsection