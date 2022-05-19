texto texto texto delegacion
@foreach ($body['sons'] as $key => $node)
    {{$key}} - nota: {{$node}} <br>
@endforeach
{{$body['visits']}}