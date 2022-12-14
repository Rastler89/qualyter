@extends('layouts.dashboard')

@section('content')
<table class="table table-hover table-striped">
    <thead>
        <th scope="col">@sortablelink('client',__('Client'))</th>
        <th scope="col">@sortablelink('agent',__('Agent'))</th>
        <th scope="col">@sortablelink('weight',__('Weight'))</th>
        <th scope="col">{{__("Comment")}}</th>
        <th scope="col">@sortablelink('created_at',__("Created"))</th>
    </thead>
    <tbody>
        @foreach($congratulations as $congratulation)
            <tr>
                <td>{{$congratulation->client}}</td>
                <td>{{$congratulation->agent}}</td>
                <td>{{$congratulation->weight}}</td>
                <td>{{$congratulation->comments}}</td>
                <td>{{$congratulation->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$congratulations->appends([])->links()}}
@endsection