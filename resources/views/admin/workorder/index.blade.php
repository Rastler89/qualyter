@extends('layouts.dashboard')

@section('content')

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
{{$workorders->links()}}
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