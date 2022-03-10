@extends('layouts.dashboard')

@section('sytles')
<link rel="stylesheet" href="{{ asset("css/custom.css") }}">
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p><strong>{{__('Name')}}</strong></p>
                        <p>{{$store->name}}</p>
                    </div>
                    <div class="col">
                        <p><strong>{{__('Language')}}</strong></p>
                        <p>{{$store->language}}</p>
                    </div>
                    <div class="col">
                        <p><strong>{{__('Phone Number')}}</strong></p>
                        <a href="tel:+@if($store->language=='ES' || $store->language==null || $store->language==' ') 34 @endif 617370097">617370097</a>
                    </div>
                </div>
            </div>
          </div>
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="accordion" id="accordionExample">
            <?php $tasks = json_decode($answer->tasks); ?>
            @foreach($tasks as $task)
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                  {{$task->code}} {{$task->name}}
                </button>
              </h2>
              <div id="collapse{{$loop->index}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <p><strong>@foreach($agents as $agent) @if($agent->id==$task->owner) {{$agent->name}} @endif @endforeach</strong></p>
                  <p>{{$task->priority}}</p>
                  <p>{!!html_entity_decode($task->description)!!}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
    </div>
    <div class="col-8 scrollable">
        <form method="POST">
              <h4>Que puntuación global nos darías?</h4>
              <div class="mb-3">
                <div class="legend" style="--s:80px">
                  <label>suspenso</label>
                  <label>suficiente</label>
                  <label>regular</label>
                  <label>Notable</label>
                  <label>Excelente</label>
                </div>
                <div class="rating" style="--s:80px">
                  <input type="radio" name="valoration1" value="1" id="valoration1-1"><label for="valoration1-1">1</label>
                  <input type="radio" name="valoration1" value="2" id="valoration1-2"><label for="valoration1-2">2</label>
                  <input type="radio" name="valoration1" value="3" id="valoration1-3"><label for="valoration1-3">3</label>
                  <input type="radio" name="valoration1" value="4" id="valoration1-4"><label for="valoration1-4">4</label>
                  <input type="radio" name="valoration1" value="5" id="valoration1-5"><label for="valoration1-5">5</label>
                </div>
              </div>
              <div class="mb-3">
                <label for="comment1" class="form-label">{{__('Comments')}}</label>
                <textarea class="form-control" id="comment1" name="comment1" row="3"></textarea>
              </div>
              <h4>Califica la rapidez de nuestro servicio</h4>
              <div class="mb-3">
                <div class="legend" style="--s:80px">
                  <label>Muy lento</label>
                  <label>Lento</label>
                  <label>Normal</label>
                  <label>Rápido</label>
                  <label>Muy rápido</label>
                </div>
                <div class="rating" style="--s:80px">
                  <input type="radio" name="valoration2" value="1" id="valoration2-1"><label for="valoration2-1">1</label>
                  <input type="radio" name="valoration2" value="2" id="valoration2-2"><label for="valoration2-2">2</label>
                  <input type="radio" name="valoration2" value="3" id="valoration2-3"><label for="valoration2-3">3</label>
                  <input type="radio" name="valoration2" value="4" id="valoration2-4"><label for="valoration2-4">4</label>
                  <input type="radio" name="valoration2" value="5" id="valoration2-5"><label for="valoration2-5">5</label>
                </div>
                <div class="mb-3">
                  <label for="comment2" class="form-label">{{__('Comments')}}</label>
                  <textarea class="form-control" id="comment2" name="comment2" row="3"></textarea>
                </div>
              </div>
              <h4>Valora la amabilidad/trato de nuestros técnicos</h4>
              <div class="mb-3">
                <div class="legend" style="--s:80px">
                  <label>Muy malo</label>
                  <label>Malo</label>
                  <label>Normal</label>
                  <label>Bueno</label>
                  <label>Excelente</label>
                </div>
                <div class="rating" style="--s:80px">
                  <input type="radio" name="valoration3" value="1" id="valoration3-1"><label for="valoration3-1">1</label>
                  <input type="radio" name="valoration3" value="2" id="valoration3-2"><label for="valoration3-2">2</label>
                  <input type="radio" name="valoration3" value="3" id="valoration3-3"><label for="valoration3-3">3</label>
                  <input type="radio" name="valoration3" value="4" id="valoration3-4"><label for="valoration3-4">4</label>
                  <input type="radio" name="valoration3" value="5" id="valoration3-5"><label for="valoration3-5">5</label>
                </div>
                <div class="mb-3">
                  <label for="comment3" class="form-label">{{__('Comments')}}</label>
                  <textarea class="form-control" id="comment3" name="comment3" row="3"></textarea>
                </div>
              </div>
              <h4>Puntúa la capacidad de resolución de las incidencia/as</h4>
              <div class="mb-3">
                <div class="legend" style="--s:80px">
                  <label>Muy malo</label>
                  <label>Malo</label>
                  <label>Normal</label>
                  <label>Bueno</label>
                  <label>Excelente</label>
                </div>
                <div class="rating" style="--s:80px">
                  <input type="radio" name="valoration4" value="1" id="valoration4-1"><label for="valoration4-1">1</label>
                  <input type="radio" name="valoration4" value="2" id="valoration4-2"><label for="valoration4-2">2</label>
                  <input type="radio" name="valoration4" value="3" id="valoration4-3"><label for="valoration4-3">3</label>
                  <input type="radio" name="valoration4" value="4" id="valoration4-4"><label for="valoration4-4">4</label>
                  <input type="radio" name="valoration4" value="5" id="valoration4-5"><label for="valoration4-5">5</label>
                </div>
                <div class="mb-3">
                  <label for="comment4" class="form-label">{{__('Comments')}}</label>
                  <textarea class="form-control" id="comment4" name="comment4" row="3"></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
</div>
@endsection