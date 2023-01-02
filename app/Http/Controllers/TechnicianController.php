<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use PDF;
use Mail;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technicians = Technician::all();

        return view('admin.technician.index', ['technicians' => $technicians]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public.technician');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tec = new Technician();

        //Section 1
        $tec->company = $request->get('company_name');
        $tec->nif = $request->get('nif')[0];
        $tec->contact = $request->get('contact_person');
        $tec->country = $request->get('country');
        $tec->region = $request->get('region');
        $tec->town = $request->get('town');
        $tec->address = $request->get('adress');
        $tec->main_phone = $request->get('phone_main');
        $tec->admin_phone = $request->get('phone_admin');
        $tec->all_phone = $request->get('phone_allday');
        $tec->main_email = $request->get('email_main');
        $tec->admin_email = $request->get('email_admin');
        $tec->all_email = $request->get('email_allday');

        //Section 2
        $arr = $request->get('services');
        if(gettype($arr)=='array') {
            if(in_array('other',$arr)) {
                $element['other'] = $request->get('other_text');
                array_push($arr,$element);
            }
            $tec->services = json_encode($arr);
            $tec->area = $request->get('area');
        }

        //Section 3
        foreach($request->get('name') as $key => $name) {
            $worker[$key] = [];
            $worker[$key]['name'] = $name;
            $worker[$key]['nif'] = $request->get('nif')[$key];


            if($request->art19!=null) {
                $fileName = $tec->company.'_art19-'.$key.'_'.time().'.'.$request->art19[$key]->extension();  
                $request->art19[$key]->move(public_path('uploads'), $fileName);
                $worker[$key]['art19'] = $fileName;
            }

            if($request->art18!=null) {
                $fileName = $tec->company.'_art18-'.$key.'_'.time().'.'.$request->art18[$key]->extension();  
                $request->art18[$key]->move(public_path('uploads'), $fileName);
                $worker[$key]['art18'] = $fileName;
            }

            if($request->medical!=null) {
                $fileName = $tec->company.'_medical-'.$key.'_'.time().'.'.$request->medical[$key]->extension();  
                $request->medical[$key]->move(public_path('uploads'), $fileName);
                $worker[$key]['medical'] = $fileName;
            }

            if($request->ppe!=null) {
                $fileName = $tec->company.'_ppe-'.$key.'_'.time().'.'.$request->ppe[$key]->extension();  
                $request->ppe[$key]->move(public_path('uploads'), $fileName);
                $worker[$key]['ppe'] = $fileName;
            }
        }
        $tec->workers = $request->get('employees');
        $tec->info_workers = json_encode($worker);

        //Section 4
        $tec->travel = $request->get('travel');
        $tec->travel_ah = $request->get('trip');
        $tec->hour = $request->get('hour');
        $tec->hour_ah = $request->get('after-hour');
        $tec->type_payment = $request->get('type_payment');
        $tec->iban = $request->get('iban');

        //Section 6
        if($request->risk!=null) {
            $fileName = $tec->company.'_risk_'.time().'.'.$request->risk->extension();  
            $request->risk->move(public_path('uploads'), $fileName);
            $tec->risk = $fileName;
        }

        if($request->preventive!=null) {
            $fileName = $tec->company.'_preventive_'.time().'.'.$request->preventive->extension();  
            $request->preventive->move(public_path('uploads'), $fileName);
            $tec->preventive = $fileName;
        }

        if($request->payment!=null) {
            $fileName = $tec->company.'_payment_'.time().'.'.$request->payment->extension();  
            $request->payment->move(public_path('uploads'), $fileName);
            $tec->certificate_pay = $fileName;
        }

        if($request->rnt!=null) {
            $fileName = $tec->company.'_rnt_'.time().'.'.$request->rnt->extension();  
            $request->rnt->move(public_path('uploads'), $fileName);
            $tec->rnt = $fileName;
        }

        if($request->rlc!=null) {
            $fileName = $tec->company.'_rlc_'.time().'.'.$request->rlc->extension();  
            $request->rlc->move(public_path('uploads'), $fileName);
            $tec->rlc = $fileName;
        }

        if($request->tax!=null) {
            $fileName = $tec->company.'_tax_'.time().'.'.$request->tax->extension();  
            $request->tax->move(public_path('uploads'), $fileName);
            $tec->tax = $fileName;
        }
        $technician = $tec;
        $tec->save();

        $array = json_decode(json_encode($technician), true);
        //return view('pdf.technician', $array);
        $data["email"] = $array['main_email'];
        $data["title"] = "OptimaRetail - Form Complete";
        $pdf = PDF::loadView('pdf.technician', $array);
  
        Mail::send('emails.technicianForm', $data, function($message)use($data, $pdf) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "OptimaRetail.pdf");
        });

        $tec->save();

        return view('public.technicianThanks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $technician = Technician::find($id);

        return view('admin.technician.view', ['technician' => $technician]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function edit(Technician $technician)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technician $technician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technician $technician)
    {
        //
    }

    public function exportPDF($id) {

        $technician = Technician::find($id);

        $array = json_decode(json_encode($technician), true);
        $pdf = PDF::loadView('pdf.technician', $array);

        return $pdf->download($technician->company.'.pdf');
    }
}
