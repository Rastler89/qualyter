@extends('layouts.dashboard')

@section('content')
<div class="accordion" id="accordionExample">
    

    <!--<div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          {{__('Filters')}}
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
        </div>
      </div>
    </div>
  </div>-->
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">@sortablelink('store',__('Store'))</th>
            <th scope="col">@sortablelink('client',__('Client'))</th>
            <th scope="col">@sortablelink('expiration',__('Expiration'))</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($answers as $answer)
        @foreach($stores as $store)
        @if($store->code == $answer->store)
        @if($store->phonenumber==null && $store->email==null)
            <tr class="table-dark">
        @else
            @switch($answer->status)
                @case(0) <tr class="table-success"> @break
                @case(1) <tr class="table-warning"> @break
                @case(3) <tr class="table-danger"> @break
            @endswitch
        @endif
            <td>
                {{$store->name}}
            </td>
            <td>
                @foreach($clients as $client)
                @if($client->id == $answer->client)
                {{$client->name}}
                @endif
                @endforeach
            </td>
            <td>
                {{$answer->expiration}}
            </td>
            <td>
                @if($store->phonenumber!=null)
                    <a href="{{route('tasks.view',['id'=>$answer->id])}}" class="btn btn-outline-primary @if($answer->user != $id && $answer->user != null) disabled @endif"><i class="align-middle" data-feather="phone"></i></a>
                @elseif($store->email!=null)
                    <a href="#" class="btn btn-outline-primary @if($answer->user != null && $answer->user != $id) disabled @endif"><i class="align-middle" data-feather="send"></i></a>
                @else 
                    <a href="{{route('stores.edit',['id'=>$store->id])}}" class="btn btn-outline-warning"><i class="align-middle" data-feather="edit"></i></a>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
    </tbody>
</table>
{{$answers->links()}}
@endsection