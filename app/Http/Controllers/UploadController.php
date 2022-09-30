<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Answer;
use App\Models\Client;
use App\Models\Store;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;
use Mail;
use App\Mail\NotExistStoreMail;


class UploadController extends Controller
{
    public function index() {
        return view('admin.uploads.index');
    }

    public function pushTasks(Request $request) {
        $respuesta = $this->exportCSVAsocciative($request,true,true);
        Store::disableAuditing();

        $count = 0;
        foreach($respuesta as $resp) {
            $store = Store::where('code','=',$resp['Proyecto Código'])->where('client','=',$resp['Código cliente'])->first();
            if($store==null) {
                $client = Client::find($resp['Código cliente']);
                $store = new Store();
                $store->code = $resp['Proyecto Código'];
                $store->name = str_replace("'",'"',utf8_encode($resp['Proyecto Nombre']));
                $store->status = true;
                $store->phonenumber = '617370097';
                $store->email = 'daniel.molina@optimaretail.es';
                $store->language = 'ES';
                $store->client = intval(($client==null || $resp['Código cliente']=='') ? 1 : $resp['Código cliente']);
                $store->contact = false;
                
                $store->save();
            }
            Task::disableAuditing();
            //Creem la tasca
            $owner = Agent::where('name','=',purge_accent(utf8_encode($resp['Responsable'])))->first();
            $task = Task::where('code','=',$resp['Código'])->first();
            if($task == null) {
                $task = new Task;
                $task->code = $resp['Código'];
                $task->name = utf8_encode($resp['Nombre']);
                $task->priority = utf8_encode($resp['Prioridad']);
                $task->owner = ($owner==null) ? 11 : $owner->id;
                $task->store = $resp['Proyecto Código'];
                if($task->owner == 11) {
                    echo $resp['Código']." -- ";print_r(purge_accent(utf8_encode($resp['Responsable'])));die();
                }
            }
            $task->expiration = date('Y-m-d h:i:s', strtotime(str_replace('/','-',$resp['Fecha Vencimiento'])));

            if($store->name=='.' || $store->name=='......' || $store->name=='...') {
                if(env('APP_NAME')!='QualyterTEST') {
                    Mail::to($owner->email)->send(new NotExistStoreMail($task->code));
                } else {
                    Mail::to('test@optimaretail.es')->send(new NotExistStoreMail($task->code));
                }
            }

            $task->save();

            $task = Task::where('code','=',$resp['Código'])->first();
            Answer::disableAuditing();
            //Si no volen contacte no generem cap visita...
            if($store != null && $store->contact) {
                $answer = Answer::where('expiration','=',date('Y-m-d', strtotime(str_replace('/','-',$resp['Fecha Vencimiento']))))->where('store','=',$task->store)->where('client','=',$resp['Código cliente'])->first();
                if($answer == null) {
                    $answer = new Answer;
                    $answer->expiration = date('Y-m-d', strtotime(str_replace('/','-',$resp['Fecha Vencimiento'])));
                    $answer->status = 0;
                    $answer->store = $task->store;
                    $answer->client = ($resp['Código cliente']==null || $resp['Código cliente']=='') ? 1 : $resp['Código cliente'];
                    $count++;
                }
                $answer->token = Str::random(8);
                $answer->save();

                $answer->tasks()->save($task);
            }

        }

        return back()->with('success','Upload tasks successfuly! '.$count.' tasks created!');
    }
    
    public function pushAgents(Request $request) {
        Agent::disableAuditing();
        $respuesta = $this->exportCSV($request);
        
        foreach($respuesta as $resp) {
            $resp[1] = str_replace('optima.retail','optimaretail',$resp[1]);
            $agent = Agent::where('email','=',$resp[1])->first();

            if($agent==null) {
                $agent = Agent::where('name','=',$resp[0])->first();
                if($agent==null) {
                    $agent = new Agent;
                }
            }
            
            $agent->name = purge_accent(utf8_encode($resp[0]));
            $agent->email = $resp[1];
            
            $agent->save();
        }
        return back()->with('success','Upload agents successfuly!');
    }

    public function pushStores(Request $request) {
        Store::disableAuditing();
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $store = Store::where('code','=',$resp[0])->first();

            if($store==null) {
                $store = new Store;
                $store->code = $resp[0];
                if(isset($sep[13])) {
                    $store->email = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($resp[13]));
                } else {
                    $store->email = '';
                }
                if(isset($resp[12])) {
                    $store->phonenumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($resp[12]));
                }
                if(isset($resp[14])) {
                    $store->language = substr($resp[14],2);
                } else {
                    $store->language = 'en';
                }
                if(isset($resp[15])) {
                    $store->contact = ($resp[15]=='SI') ? 1 : 0; 
                } else {
                    $store->contact = 1;
                }
            }
            $client = Client::find($resp[5]);

            $store->name = utf8_encode($resp[1]);
            $store->status = ($resp[7]=='Abierto') ? 1 : 0;
            $store->client = ($client==null) ? 1 : $resp[5];

            $store->save();       

        }
        return back()->with('success','Upload stores successfuly!');
    }

    public function pushClients(Request $request) {
        Client::disableAuditing();
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $client = Client::find($resp[0]);

            if($client==null) {
                $client = new Client;
                $client->delegation = (strlen($resp[3])) ? 'ES' : $resp[3];
                $client->phonenumber = ($resp[5]==null) ? '617370097' : $resp[5];
                $client->email = ($resp[6]==null) ? 'daniel.molina@optimaretail.es' : $resp[6];
                $client->language = ($resp[17]==null || strlen($resp[17]) > 2) ? 'ES' : $resp[17];
                $client->id = $resp[0];
            }

            $client->name = utf8_encode($resp[2]);
            
            $client->save();
        }

        return back()->with('success','Upload clients successfuly!');
        
    }

    private function exportCSV(Request $request, $header = true) {
        $file = $request->file('file');
        $name = $request->file('file')->getClientOriginalName();
        
        $file->move(storage_path(),$name);
        $fileName = storage_path().'/'.$name;

        $response = [];

        if(($open = fopen($fileName,'r')) !== FALSE) {
            while(($data = fgetcsv($open,1000,';')) !== FALSE) {
                $response[] = $data;
            }
            fclose($open);
        }
        if($header) {
            unset($response[0]);
        }

        File::delete($fileName);

        return $response;
    }

    private function exportCSVAsocciative(Request $request) {
        $file = $request->file('file');
        $name = $request->file('file')->getClientOriginalName();
        
        $file->move(storage_path(),$name);
        $fileName = storage_path().'/'.$name;

        $response = [];
        $result = [];

        if(($open = fopen($fileName,'r')) !== FALSE) {
            while(($data = fgetcsv($open,0,';')) !== FALSE) {
                if(empty($response)) {
                    foreach($data as $key => $field) {
                        $response[$key] = utf8_encode($field);
                        if(strpos($response[$key],'Cï¿½digo') !== false) {
                            $response[$key] = str_replace('Cï¿½digo','Código',$response[$key]);
                        }
                        if(strpos($response[$key],'Finalizaciï¿½n') !== false) {
                            $response[$key] = str_replace('Finalizaciï¿½n','Finalización',$response[$key]);;
                        }

                    }
                } else {
                    $result[] = array_combine($response,$data);
                }
            }
            fclose($open);
        }

        File::delete($fileName);

        return $result;
    }

    
}
