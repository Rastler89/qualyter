@extends('layouts.dashboard')

@section('content')

<table class="table table-hover table-striped">
    <thead>
        <th scope="col">{{__('Store')}}</th>
        <th scope="col">{{__('Impact')}}</th>
        <th scope="col">{{__('Responsable')}}</th>
        <th scope="col">{{__('Created By')}}</th>
        <th scope="col">{{__('Closing day')}}</th>
        <th scope="col"></th>
    </thead>
    <tbody>
        @foreach($incidences as $incidence)
            @switch($incidence->status)
                @case(0) <tr class="table-danger"> @break
                @case(1) <tr class="table-warning"> @break
            @endswitch
                <td>
                    {{$incidence->store}}
                </td>
                <td>
                    {{$incidence->impact}}
                </td>
                <td>
                    {{$incidence->responsable}}
                </td>
                <td>
                    {{$incidence->owner}}
                </td>
                <td>
                    {{$incidence->closed}}
                </td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection