<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Answer;
use App\Models\Store;
use Illuminate\Http\Request;
use Artisan;

class ClientController extends Controller
{
    public function index(Request $request) {
        $filters = $request->query();
        if(isset($filters['filtered'])  && isset($filters['filters'])) {
            $filters = $filters['filters'];
        }

        $clients = Client::query();

        if(!empty($filters['client']) && $filters['client'] != '') {
            $clients->where('name','LIKE','%'.$filters['client'].'%');
        }
        if(!empty($filters['father']) && $filters['father'] != '') {
            $clients->where('father','=',$filters['father']);
        }
        if(!empty($filters['client']) && $filters['client'] != '') {
            $clients->where('name','LIKE','%'.$filters['client'].'%');
        }
        if(!empty($filters['central'])) {
            $clients->where('delegation','=','00');
        }
        if(!empty($filters['extra'])) {
            $clients->where('extra','=',1);
        }


        $clients = $clients->sortable()->paginate(25);
        $fathers = Client::where('delegation','=','00')->get();

        return view('admin.client.index',['clients' => $clients, 'fathers' => $fathers, 'filters' => $filters]);
    }

    public function new() {
        $clients = Client::where('delegation','=','00')->get();
        return view('admin.client.profile', ['client' => null, 'clients' => $clients]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'country' => 'required',
            'email' => ['required','min:6'],
        ]);

        $url = 'https://restcountries.com/v2/name/'.str_replace(' ','%20',$request->get('country'));

        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp);
        
        $client = new Client;
        $client->name = $request->get('name');
        $client->phonenumber = $request->get('phonenumber');
        $client->email = $request->get('email');
        if($request->get('central')!=null) {
            $client->delegation = '00';
        } else {
            $client->delegation = $resp[0]->alpha2Code;
        }
        $client->language = $resp[0]->languages[0]->iso639_1;
        $client->extra = $request->get('extra') == 'on';
        $client->father = ($request->get('father') == '--') ? NULL : $request->get('father');
        $client->whatsapp = ($request->get('whatsapp') == 'on') ? true : false;


        $client->save();
        
        return redirect()->route('clients')->with('success','Client added successfuly!');
    }

    public function edit($id) {
        $client = Client::find($id);
        $clients = Client::where('delegation','=','00')->get();

        return view('admin.client.profile',['client' => $client, 'clients' => $clients]);
    }
    
    public function update(Request $request, $id) {
        $client = Client::find($id);
        
        if($request->get('country') != '--') {
            $url = 'https://restcountries.com/v2/name/'.str_replace(' ','%20',$request->get('country'));

            $curl = curl_init($url);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

            $resp = curl_exec($curl);
            curl_close($curl);
            $resp = json_decode($resp);

            if($request->get('central')!=null) {
                $client->delegation = '00';
            } else {
                $client->delegation = $resp[0]->alpha2Code;
            }
            $client->language = $resp[0]->languages[0]->iso639_1;
        } else {
            if($request->get('central')=='on') {
                $client->delegation = '00';
            }
        }

        $client->name = $request->get('name');
        $client->phonenumber = $request->get('phonenumber');
        $client->email = $request->get('email');
        $client->extra = $request->get('extra') == 'on';
        $client->father = ($request->get('father') == '--') ? NULL : $request->get('father');
        $client->whatsapp = ($request->get('whatsapp') == 'on') ? true : false;

        $client->save();
        
        return redirect()->route('clients')->with('success','Client updated successfuly!');
    }

    public function send($id) {
        $artisan = Artisan::call('note:monthly',['user'=>$id]);
        $output = Artisan::output();
        
        return redirect()->route('clients')->with('success',"previous month's summary sent");
    }

    public function download($client){

        //helpers
        $first_day = first_month_day();
        $last_day = last_month_day();

        $cliente = Client::find($client);
        
        $delegations = Client::where('father','=',$client)->get();
        $allResults = [];
        $data = [];
        $answersArray = [];
        //$average = getAverage($client);
        foreach($delegations as $delegation){
            $datosDelegacion = [];
            $answers = Answer::where('client','=',$delegation->id)->whereIn('status',[2,4,5])->whereBetween('updated_at',[$first_day,$last_day])->get();
            foreach($answers as $answer) {
                $datosAnswer = [];
                $store =  Store::where('code','=',$answer->store)->first();
                
                array_push($datosAnswer, $store->name);
                array_push($datosAnswer, $answer->expiration);
                
                array_push($datosAnswer, $answer->answer);

                array_push($datosDelegacion, $datosAnswer);
                array_push($answersArray, $answers);
            }
            array_push($data, $datosDelegacion);
        }

        
       if(count($answersArray)>0){
               //datos fichero
       $today = date("Y-m-d");
       $fileName = str_replace("-","",$today).str_replace(" ","",$cliente->name). ".xls";
       
       $total0 = 0;
       $total1 = 0;
       $total2 = 0;
       $total3 = 0;
       $divisor = count($answersArray);
       
       header("Content-Disposition: attachment; filename=\"$fileName\"");
       header("Content-Type: application/vnd.ms-excel");
       
       echo "TIENDA" . "\t" . "Fecha". "\t" . "PREGUNTA 1". "\t" . "COMENTARIO". "\t". "PREGUNTA 2". "\t" . "COMENTARIO". "\t". "PREGUNTA 3". "\t" . "COMENTARIO". "\t". "PREGUNTA 4". "\t" . "COMENTARIO" . "\n";
       foreach($data as $delegacion){
           
           foreach($delegacion as $row){
               
               $respuestas = json_decode($row[2],true);
               echo  utf8_decode($row[0]);
               echo "\t" .$row[1];
               echo "\t" . $respuestas['valoration'][0];
               echo "\t" . utf8_decode($respuestas['comment'][0]);
               echo "\t" . $respuestas['valoration'][1];
               echo "\t" . utf8_decode($respuestas['comment'][1]);
               echo "\t" . $respuestas['valoration'][2];
               echo "\t" . utf8_decode($respuestas['comment'][2]);
               echo "\t" . $respuestas['valoration'][3];
               echo "\t" . utf8_decode($respuestas['comment'][3]) . "\n";

               $total0 = $total0 + (int)$respuestas['valoration'][0];
               $total1 = $total1 + (int)$respuestas['valoration'][1];
               $total2 = $total2 + (int)$respuestas['valoration'][2];
               $total3 = $total3 + (int)$respuestas['valoration'][3];
           }
       }

       
       $media0 = round($total0 / $divisor,2);
       $media1 = round($total1 / $divisor,2);
       $media2 = round($total1 / $divisor,2);
       $media3 = round($total1 / $divisor,2);

       echo "\n" . "\t". "PUNTUACION MEDIA" . "\t" . $media0 . "\t". "\t" . $media1 . "\t" . "\t" . $media2 . "\t" . "\t".$media3;
       exit;

       }else {
        return redirect()->route('clients')->with('warning',"No data found");
       }

}
}
