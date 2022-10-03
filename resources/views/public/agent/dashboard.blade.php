@extends('layouts.agent')

@section('styles')
@endsection

@section('content')
<table class="table table-hover table-striped">
    <thead>
        <th scope="col">@sortablelink('store',__('Store'))</th>
        <th scoep="col">{{__('Work Order')}}</th>
        <th scope="col">@sortablelink('status',__('Status'))</th>
        <th scope="col">@sortablelink('impact',__('Impact'))</th>
        <th scope="col">@sortablelink('created_at',__('Created'))</th>
        <th scope="col">@sortablelink('closed',__('Control day'))</th>
        <th scope="col"></th>
    </thead>
    <tbody>
        @foreach($incidences as $incidence)
            @switch($incidence->status)
                @case(1) <tr class="table-sent"> @break
                @case(2) <tr class="table-warning"> @break
                @case(3) <tr class="table-danger"> @break
                @case(4) <tr class="table-success"> @break
            @endswitch
                <td>
                    @foreach($stores as $store)
                    @if($store->code == $incidence->store)
                        {{$store->name}}
                    @endif
                    @endforeach
                </td>
                <td>
                    <?php $workOrder = json_decode($incidence->order,true); ?>
                    {{$workOrder['code']}}
                </td>
                <td>
                    @switch($incidence->status)
                        @case(0)
                            {{__('Open')}}
                            @break
                        @case(1)
                            {{__('Pending reply')}}
                            @break
                        @case(2)
                            {{__('In process')}}
                            @break
                        @case(3)
                            {{__('Refused')}}
                            @break
                        @case(4)
                            {{__('Complete')}}
                            @break
                    @endswitch
                </td>
                <td>
                    @switch($incidence->impact)
                        @case(0)
                            <button type="button" class="btn btn-outline-danger">{{__('Urgent')}}</button>
                            @break
                        @case(1)
                            <button type="button" class="btn btn-outline-high">{{__('High')}}</button>
                            @break
                        @case(2)
                            <button type="button" class="btn btn-outline-warning">{{__('Medium')}}</button>
                            @break
                        @case(3)
                            <button type="button" class="btn btn-outline-success">{{__('Low')}}</button>
                            @break
                    @endswitch
                </td>
                <td>
                    {{$incidence->created_at}}
                </td>
                <td>
                    {{$incidence->closed}}
                </td>
                <td>
                    <a target="_blank" href="{{route('incidences.agent',['id' => $incidence->id,'code'=>$incidence->token])}}" class="btn btn-outline-primary"><i class="align-middle" data-feather="eye"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$incidences->links()}}
@endsection
