@extends('layouts.dashboard')

@section('content')
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">{{__('Agent')}}</th>
      <th scope="col">{{__("Question 1")}}</th>
      <th scope="col">{{__("Question 2")}}</th>
      <th scope="col">{{__("Question 3")}}</th>
      <th scope="col">{{__("Question 4")}}</th>
      <th scope="col">{{__('Total answers')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($leaderboard as $leader)
    @if($loop->iteration%2==0) 
    <tr class="table-light">
    @else
    <tr class="table-primary">
    @endif
      <td>{{$leader['agent']->name}}</td>
      <td class="text-center"><?=number_format($leader[0],2)?></td>
      <td class="text-center"><?=number_format($leader[1],2)?></td>
      <td class="text-center"><?=number_format($leader[2],2)?></td>
      <td class="text-center"><?=number_format($leader[3],2)?></td>
      <td class="text-center">{{$leader['total']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection