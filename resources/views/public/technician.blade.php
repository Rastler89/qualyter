@extends('layouts.public')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/public.css') }}" />
<link rel="stylesheet" href="{{ asset('css/technician.css') }}" />
@endsection

@section('content')
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <h4 class="alert-heading">{{__("OPTIMA RETAIL REGULATIONS")}}</h4>
  <p>{{__("Identify yourself in the shops as an OPTIMA RETAIL technician.")}}<br/>
    {{__("Wear Optima Retail corporate clothing. If you do not have it, please request it to mireia.navarro@optimaretail.es and we will send it to you as soon as possible. During the first interventions wear neurtra clothing without logos.")}}<br/>
    {{__("Make a MOREAPP report in the shop (no other type of report is valid).")}}<br/>
    {{__("Do not leave any documentation in the shop (delivery notes, invoices, etc.) Always send it to us by email.")}}<br/>
    {{__("No subcontracting is allowed. Always work with your own staff.")}}<br/>
    {{__("The priority is ALWAYS that the shop staff is happy after your intervention, even if it has not been possible to solve the incident. Be polite and if you detect any problem, promptly notify the corresponding Optima Retail coordinator.")}}</p>
  <p>{{__("These rules are MANDATORY to collaborate with OPTIMA RETAIL.")}}</p>
  <p>{{__("As soon as you start working with us, we will need your Civil Liability Insurance.")}}<br/>
    {{__("The obligatory information on the invoice is: Order Number (OT), E-mail, NIF, IBAN.")}}</p>
  <p>{{__("The first 5 interventions will be paid as soon as we receive the invoice. In the case of regular collaborations, payment will be due within 30 days, being the 10th and 25th of each month.")}}<br/>
    {{__("Invoices should always be sent to: administration@optimaretail.es")}}</p>
  <p>{{__("If you have any doubts or general queries about the collaboration, you can contact the technical team at tecnicos@optimaretail.es. For issues related to the interventions, you should always contact the coodinator who commissioned the work, and in the event that he/she is not available, you can call 24h (+34) 911 43 80 61. ")}}</p>
  <p>{{__("Please note that this collaboration is completely voluntary and if at any time you wish to stop collaborating, you should contact the technical department by sending an email to tecnicos@optimaretail.es.")}}</p>

</div>
<form method="post" action="" id="formTechnician"  enctype="multipart/form-data">
  @csrf
<section id="section1" class="row">
  <h3>{{__("Contact details")}}</h3>
  <div class="col-md-4 p-3">
    <label for="company_name" class="form-label">{{__('Company Name')}}</label>
    <input type="email" class="form-control" id="company_name" name="company_name" required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="nif" class="form-label">{{__('NIF/VAT')}}</label>
    <input type="nif" class="form-control" id="nif" name="nif" />
  </div>
  <div class="col-md-4 p-3">
    <label for="contact_person" class="form-label">{{__('Contact person')}}</label>
    <input type="text" class="form-control" id="contact_person" name="contact_person" required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="country" class="form-label">{{__('Country')}}</label>
    <input type="text" class="form-control" id="country" name="country" required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="region" class="form-label">{{__('Region')}}</label>
    <input type="text" class="form-control" id="region" name="region" />
  </div>
  <div class="col-md-4 p-3">
    <label for="town" class="form-label">{{__('Town')}}</label>
    <input type="text" class="form-control" id="town" name="town" required/>
  </div>
  <div class="col-md-12 p-3">
    <label for="adress" class="form-label">{{__('Address')}}</label>
    <input type="text" class="form-control" id="adress" name="adress" required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="phone_main" class="form-label">{{__('Main phone')}}</label>
    <input type="text" class="form-control" id="phone_main" name="phone_main" required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="phone_admin" class="form-label">{{__('Administration phone')}}</label>
    <input type="text" class="form-control" id="phone_admin" name="phone_admin" />
  </div>
  <div class="col-md-4 p-3">
    <label for="phone_allday" class="form-label">{{__('24h phone')}}</label>
    <input type="text" class="form-control" id="phone_allday" name="phone_allday" />
  </div>
  <div class="col-md-4 p-3">
    <label for="email_main" class="form-label">{{__('Main mail')}}</label>
    <input type="email" class="form-control" id="email_main" name="email_main"  required/>
  </div>
  <div class="col-md-4 p-3">
    <label for="email_admin" class="form-label">{{__('Administration mail')}}</label>
    <input type="email" class="form-control" id="email_admin" name="email_admin" />
  </div>
  <div class="col-md-4 p-3">
    <label for="email_allday" class="form-label">{{__('24h mail')}}</label>
    <input type="email" class="form-control" id="email_allday" name="email_allday" />
  </div>
  <button type="button" class="col-md-12 btn btn-success btnNext" id="firstStep" style="display:none">{{__('Next')}}</button>
</section>
<section id="section2" class="row">
  <h3>{{__('Services')}}</h3>
  <div class="col-md-12 p-3 row services">
    <h4>{{__('What services do you offer?')}}</h4>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="masonry" id="masonry" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Masonry')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="carpentry" id="carpentry" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Carpentry')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="metal_carpentry" id="metal_carpentry" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Metal carpentry')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="locksmith" id="locksmith" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Locksmith')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="air_conditioning" id="air_conditioning" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Air conditioning')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="glassware" id="glassware" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Glassware')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="decoration/furniture" id="decoration" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Decoration/Furniture')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="electricity" id="electricity" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Electricity')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="plumbing" id="plumbing" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Plumbing')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="graphics" id="graphics" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Graphics')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="pci" id="pci" name="services[]">
      <label class="form-check-label" for="services">
        {{__('PCI')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="paints" id="paints" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Paints')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="pests" id="pests" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Pests')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="security" id="security" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Security')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="supplies" id="supplies" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Supplies')}}
      </label>
    </div>
    <div class="form-check col-md-3">
      <input class="form-check-input" type="checkbox" value="other" id="other" name="services[]">
      <label class="form-check-label" for="services">
        {{__('Other')}}:
      </label>
      <div class="form-check">
        <input type="text" class="form-control" id="other_text" name="other_text" style="display:none"/>
      </div>
    </div>
    <div class="form-check col-md-12">
      <label class="form-check-label" for="area">{{__('Area of operation')}}</label>
      <input type="text" class="form-control" id="area" name="area" required/>
    </div>
  </div>
  
  <button type="button" class="col-md-12 btn btn-success btnNext" id="secondStep" style="display:none">{{__('Next')}}</button>
</section>
<section id="section3" id="row">
  <h3>{{__('Employees')}}</h3>
  <div class="form-check col-md-4 m-auto">
    <label class="form-check-label" for="employees">{{__('Number of employees')}}</label>
    <input type="number" class="form-control" id="employees" name="employees" min="1" require/>
  </div>
  <div class="col-md-12 row" id="workerBody"></div>

  <button type="button" class="col-md-12 btn btn-success btnNext" id="thirdStep" style="display:none">{{__('Next')}}</button>
</section>
<section id="section4" class="row">
  <h3>{{__('Rates')}}</h3>
  <div class="col-md-6 p-3">
    <label class="form-label" for="travel">{{__('Travel')}}</label>
    <input type="number" class="form-control" id="travel" name="travel" required/>
  </div>
  <div class="col-md-6 p-3">
    <label class="formlabel" for="trip">{{__('Urgent trip')}}</label>
    <input type="number" class="form-control" id="trip" name="trip" required/>
  </div>
  <div class="col-md-6 p-3">
    <label class="form-label" for="hour">{{__('Hour')}}</label>
    <input type="number" class="form-control" id="hour" name="hour" required/>
  </div>
  <div class="col-md-6 p-3">
    <label class="form-label" for="after-hour">{{__('After hour')}}</label>
    <input type="number" class="form-control" id="after-hour" name="after-hour" required/>
  </div>
  <strong>{{__("We cannot receive VAT invoices from any EUROPEAN country except UK, SWEDEN AND DENMARK.")}}</strong>
  <div class="col-md-12 p-3">
    <label class="form-label" for="type_payment">{{__('Type of payment')}}</label>
    <select class="form-select" aria-label="" id="type_payment" name="type_payment">
      <option selected>{{__('Please select one')}}</option>
      <option value="standard">{{__('30-day transfer')}}</option>
      <option value="confirmin">{{__('Confirming Standard 30 day')}}</option>
    </select>
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="iban">{{__('IBAN')}}</label>
    <input type="text" class="form-control" id="iban" name="iban" required/>
  </div>
  <button type="button" class="col-md-12 btn btn-success btnNext" id="fourthStep" style="display:none">{{__('Next')}}</button>
</section>
<section id="section5" class="row">
  <h3>{{__("Documentation")}}</h3>
  <div class="col-md-12 p-3">
    <label class="form-label" for="risk">{{__('Risk assessment')}}</label>
    <input type="file" class="form-control" id="risk" aria-describedby="inputGroupFileAddon01" name="risk">
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="preventive">{{__('Planning of preventive activity')}}</label>
    <input type="file" class="form-control" id="preventive" aria-describedby="preventive" name="preventive">
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="payment">{{__('Certificate of prevention with payment period and adopted modalities')}}</label>
    <input type="file" class="form-control" id="payment" aria-describedby="payment" name="payment">
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="rnt">{{__('RNT')}}</label>
    <input type="file" class="form-control" id="rnt" aria-describedby="rnt" name="rnt">
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="rlc">{{__('RLC')}}</label>
    <input type="file" class="form-control" id="rlc" aria-describedby="rlc" name="rlc">
  </div>
  <div class="col-md-12 p-3">
    <label class="form-label" for="tax">{{__('Tax clearance certificate')}}</label>
    <input type="file" class="form-control" id="tax" aria-describedby="tax" name="tax">
  </div>
  <button type="button" class="col-md-12 btn btn-success" id="btnSend">{{__('Next')}}</button>
</section>
</form>

<span style="display:none">
<div id="originalForm" class="row">
<hr class="mt-3"/>
<div class="col-md-6 p-3">
  <label class="form-label" for="name[]">{{__('Name')}}</label>
  <input type="text" class="form-control" id="name[]" name="name[]" />
</div>
<div class="col-md-6 p-3">
  <label class="form-label" for="nif[]">{{__('Nif')}}</label>
  <input type="text" class="form-control" id="nif[]" name="nif[]" />
</div>
<div class="col-md-6 p-3">
  <label class="form-label" for="art19[]">{{__('Training in occupational hazards in accordance with art. 19 of the collective agreement')}}</label>
  <input type="file" class="form-control" id="art19[]" name="art19[]" aria-describedby="art19">
</div>
<div class="col-md-6 p-3">
  <label class="form-label" for="art18[]">{{__('Occupational risk information certificate according to art. 18 of the collective labour agreement')}}</label>
  <input type="file" class="form-control" id="art18[]" name="art18[]" aria-describedby="art18">
</div>
<div class="col-md-6 p-3">
  <label class="form-label" for="medical[]">{{__('Certificate of medical fitness ')}}</label>
  <input type="file" class="form-control" id="medical[]" name="medical[]" aria-describedby="medical">
</div>
<div class="col-md-6 p-3">
  <label class="form-label" for="ppe[]">{{__('Certificate of delivery of PPE')}}</label>
  <input type="file" class="form-control" id="ppe[]" name="ppe[]" aria-describedby="ppe[]">
</div>
</div>
</span>
@endsection

@section('javascript')
<script>
$( document ).ready(function() {
  var page = 1;

  $("#employees").keyup(function() {
    if($("#employees").val()!='' && $("#employees").val()!=null) {
      $("#thirdStep").css('display','block');
    } else {
      $("#thirdStep").css('display','none');
    }
    $("#workerBody").empty();
    for(i=0; i<$("#employees").val();i++) {
      $('#originalForm').clone().appendTo('#workerBody')
    }
  });

  $(".btnNext").click(function() {
    let old_section = "#section"+(page)
    page = page + 1;
    let section = "#section"+page;
    $(old_section).css('display','none');
    $(section).css('display','block');
  });

  $("#other").change(function() {
    if($("#other").is(':checked')) {
      $('#other_text').css('display','block');
    } else {
      $('#other_text').css('display','none');
    }
  });

  $("#btnSend").click(function(){
    $("#formTechnician").submit();
  })

  $("input[required]").keyup( function() {
    console.log('hola');
    firstStep();
    secondStep();
    fourthStep();
  });

  // Verifications
});
//Functions
function firstStep() {
  let i = 0;
  if($("#company_name").val()!=null && $("#company_name").val()!='') {
    i = i + 1;
  }
  if($("#contact_person").val()!=null && $("#contact_person").val()!='') {
    i = i + 1;
  }
  if($("#country").val()!=null && $("#country").val()!='') {
    i = i + 1;
  }
  if($("#town").val()!=null && $("#town").val()!='') {
    i = i + 1;
  }
  if($("#adress").val()!=null && $("#adress").val()!='') {
    i = i + 1;
  }
  if($("#phone_main").val()!=null && $("#phone_main").val()!='') {
    i = i + 1;
  }
  if($("#email_main").val()!=null && $("#email_main").val()!='') {
    i = i + 1;
  }
  if(i==7) {
    $("#firstStep").css('display','block');
  } else {
    $("#firstStep").css('display','none');
  }
}

function secondStep() {
  var checked = $(".services input[type=checkbox]:checked").length;
  if(checked>0 && $('#area').val()!=null && $('#area').val()!='') {
    $('#secondStep').css('display','block');
  } else {
    $('#secondStep').css('display','none');
  }
}

function fourthStep() {
  let i = 0;
  if($("#travel").val()!=null && $("#travel").val()!='') {
    i = i + 1;
  }
  if($("#trip").val()!=null && $("#trip").val()!='') {
    i = i + 1;
  }
  if($("#hour").val()!=null && $("#hour").val()!='') {
    i = i + 1;
  }
  if($("#after-hour").val()!=null && $("#after-hour").val()!='') {
    i = i + 1;
  }
  if($("#iban").val()!=null && $("#iban").val()!='') {
    i = i + 1;
  }
  if(i==5) {
    $("#fourthStep").css('display','block');
  } else {
    $("#fourthStep").css('display','none');
  }
}
</script>
@endsection