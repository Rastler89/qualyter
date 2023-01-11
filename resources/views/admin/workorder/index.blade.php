@extends('layouts.dashboard')

@section('content')
<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filters"><i class="align-middle" data-feather="filter"></i></button>
</div>
<form method="GET">
<div class="modal fade" id="filters" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterLabel">{{__("Filters")}}</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">{{__('Code')}}</label>
                                <input type="text"  class="form-control" name="code" placeholder="{{__('Code')}}" @if(!empty($filters) && isset($filters['code'])) value="{{$filters['code']}}" @endif/>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="submit" class="btn btn-primary">{{__("Search")}}</button>
            </div>
        </div>
    </div>
</div>
</form>
<table class=" table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">{{__('Code')}}</th>
            <th scope="col">{{__('Name')}}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($workorders as $workorder)
        <tr>
            <td>{{$workorder->code}}</td>
            <td>{{$workorder->name}}</td>
            <td>
                @if($workorder->answer_id!=null)
                <button type="button" class="btn btn-danger" onClick="deleteWO('{{$workorder->code}}');">{{__("Cancel")}}</button>
                @endif
            </td>
        </tr>
        @endforeach        
    </tbody>
</table>
{{$workorders->appends([
        'filters' => $filters,
        'filtered' => 'yes'
    ])->links()}}
@endsection

@section('javascript')
<script>
    function deleteWO(id) {
        if(confirm('{{__("WO will be cancelled, are you sure?" )}}: '+id) == true) {
            let deleteUrl = '/workorder/'+id.replace('/','_')+'/cancel';
            $.ajax({
                type: "DELETE",
                url: deleteUrl,
                data: {
                    "_token": "{{csrf_token()}}"
                }
            });
            alert('{{__("WO cancelled")}}')
            setTimeout(window.location.reload(), 3000)
        }
    }
</script>
@endsection