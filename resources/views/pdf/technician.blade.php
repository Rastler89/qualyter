<?php
 $array = json_decode($services,true);
 foreach($array as $key => $value) {
     if(gettype($value)=='array') {
         $array[$key]=$value['other'];
     }
 }
 $services = $array;
 $info_workers = json_decode($info_workers,true);
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
  <div class="row container p-3">
    <div class="col-12">
        <div class="mb-4">
            <strong>{{$company}}</strong> - {{$nif}}
            <br />
            {{__("Contact")}}: <strong>{{$contact}}</strong>
        </div>
<div class="row">
<div class="col-3">
<div class="text-muted">{{__('Country')}}</div>
<strong>{{$country}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('Region')}}</div>
<strong>{{$region}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('Town')}}</div>
<strong>{{$town}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('Address')}}</div>
<strong>{{$address}}</strong>
</div>
</div>
<hr class="my-4" />
<div class="row">
<div class="col-4">
<div class="text-muted">{{__('Main phone')}}</div>
<strong>{{$main_phone}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__('Administration phone')}}</div>
<strong>{{$admin_phone}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__('24h phone')}}</div>
<strong>{{$all_phone}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__('Main email')}}</div>
<strong>{{$main_email}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__('Administration email')}}</div>
<strong>{{$admin_email}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__('24h email')}}</div>
<strong>{{$all_email}}</strong>
</div>
</div>
<hr class="my-4" />
<div class="row">
<div class="col-6">
<div class="text-muted">{{__('Services')}}</div>
<strong>
@foreach($services as $service)
{{$service}}
@endforeach
</strong>
</div>
<div class="col-6">
<div class="text-muted">{{__('Area')}}</div>
<strong>{{$area}}</strong>
</div>
</div>
<hr class="my-4" />
<div class="row">
<div class="col-3">
<div class="text-muted">{{__('Travel')}}</div>
<strong>{{$travel}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('Urgent trip')}}</div>
<strong>{{$travel_ah}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('Hour')}}</div>
<strong>{{$hour}}</strong>
</div>
<div class="col-3">
<div class="text-muted">{{__('After hour')}}</div>
<strong>{{$hour_ah}}</strong>
</div>
<div class="col-6">
<div class="text-muted">{{__('Type of payment')}}</div>
<strong>{{$type_payment}}</strong>
</div>
<div class="col-6">
<div class="text-muted">{{__('IBAN')}}</div>
<strong>{{$iban}}</strong>
</div>
</div>
<hr class="my-4" />
<div class="row">
<div class="col-12">
<div class="text-muted">{{__('Nº of employees')}}</div>
<strong>{{$workers}}</strong>
</div>
@foreach($info_workers as $worker)
<div class="col-4">
<div class="text-muted">{{__("Name")}}</div>
<strong>{{$worker['name']}}</strong>
</div>
<div class="col-4">
<div class="text-muted">{{__("NIF")}}</div>
<strong>{{$worker['nif']}}</strong>
</div>
@endforeach
</div>
</div>
</div>
<h4 class="mt-5 text-center">{{__("OPTIMA RETAIL REGULATIONS")}}</h4>
<p class="text-muted text-justify mx-4">{{__("Identify yourself in the shops as an OPTIMA RETAIL technician.")}}<br/>
{{__("Wear Optima Retail corporate clothing. If you do not have it, please request it to mireia.navarro@optimaretail.es and we will send it to you as soon as possible. During the first interventions wear neurtra clothing without logos.")}}<br/>
{{__("Make a MOREAPP report in the shop (no other type of report is valid).")}}<br/>
{{__("Do not leave any documentation in the shop (delivery notes, invoices, etc.) Always send it to us by email.")}}<br/>
{{__("No subcontracting is allowed. Always work with your own staff.")}}<br/>
{{__("The priority is ALWAYS that the shop staff is happy after your intervention, even if it has not been possible to solve the incident. Be polite and if you detect any problem, promptly notify the corresponding Optima Retail coordinator.")}}</p>
<p class="text-muted text-justify mx-4">{{__("These rules are MANDATORY to collaborate with OPTIMA RETAIL.")}}</p>
<p class="text-muted text-justify mx-4">{{__("As soon as you start working with us, we will need your Civil Liability Insurance.")}}<br/>
{{__("The obligatory information on the invoice is: Order Number (OT), E-mail, NIF, IBAN.")}}</p>
<p class="text-muted text-justify mx-4">{{__("The first 5 interventions will be paid as soon as we receive the invoice. In the case of regular collaborations, payment will be due within 30 days, being the 10th and 25th of each month.")}}<br/>
{{__("Invoices should always be sent to: administration@optimaretail.es")}}</p>
<p class="text-muted text-justify mx-4">{{__("If you have any doubts or general queries about the collaboration, you can contact the technical team at tecnicos@optimaretail.es. For issues related to the interventions, you should always contact the coodinator who commissioned the work, and in the event that he/she is not available, you can call 24h (+34) 911 43 80 61. ")}}</p>
<p class="text-muted text-justify mx-4">{{__("Please note that this collaboration is completely voluntary and if at any time you wish to stop collaborating, you should contact the technical department by sending an email to tecnicos@optimaretail.es.")}}</p>
<div class="text-center">
<img src="https://optimaquality.es/img/fixner_logo3.png" />
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>