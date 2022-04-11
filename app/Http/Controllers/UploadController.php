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


class UploadController extends Controller
{
    public function index() {
        return view('admin.uploads.index');
    }

    public function pushTasks(Request $request) {
        $respuesta = $this->exportCSV($request);
        foreach($respuesta as $resp) {
            $store = Store::where('code','=',$resp[15])->where('client','=',$resp[22])->first();
            if($store==null) {
                $store = new Store();
                $store->code = $resp[15];
                $store->name = utf8_encode($resp[17]);
                $store->status = true;
                $store->phonenumber = '617370097';
                $store->email = 'daniel.molina@optimaretail.es';
                $store->language = 'ES';
                $store->client = ($resp[22]==null || $resp[22]=='') ? 1 : $resp[22];
                $store->contact = false;
                
                $store->save();
            }

            $owner = Agent::where('name','=',utf8_encode($resp[8]))->first();
            $task = Task::where('code','=',$resp[0])->first();
            if($task == null) {
                $task = new Task;
                $task->code = $resp[0];
                $task->name = utf8_encode($resp[1]);
                $task->priority = utf8_encode($resp[12]);
                $task->owner = ($owner==null) ? 11 : $owner->id;
                $task->store = $resp[15];
                $task->description = htmlentities($resp[26], ENT_QUOTES, "UTF-8"); 
            }
            $task->expiration = date('Y-m-d h:i:s', strtotime($resp[4]));

            if($store->contact==false) {
                $task->save();
                continue;
            }
            

            if($store != null && $store->contact) {
                $answer = Answer::where('expiration','=',date('Y-m-d',strtotime($resp[4])))->where('store','=',$task->store)->where('client','=',$resp[22])->first();
                if($answer == null) {
                    $answer = new Answer;
                    $answer->expiration = date('Y-m-d',strtotime($resp[4]));
                    $answer->status = 0;
                    $answer->store = $task->store;
                    $array[] = $task;
                    $answer->tasks = json_encode($array);
                    $answer->client = ($resp[22]==null || $resp[22]=='') ? 1 : $resp[22];
                } else {
                    $array = json_decode($answer->tasks);
                    $array[] = $task;
                    $answer->tasks = json_encode($array);
                }
                $answer->token = Str::random(8);

                $answer->save();       

            }
            $task->save();
            $array = null;
        }

        return back()->with('success','Upload tasks successfuly!');
    }
    
    public function pushAgents(Request $request) {

        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $agent = Agent::where('email','=',$resp[1])->first();

            if($agent==null) {
                $agent = Agent::where('name','=',$resp[0])->first();
                if($agent==null) {
                    $agent = new Agent;
                }
            }

            $agent->name = utf8_encode($resp[0]);
            $agent->email = $resp[1];

            $agent->save();
        }
        return back()->with('success','Upload agents successfuly!');
    }

    public function pushStores(Request $request) {
        
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $store = new Store;

            $client = Client::find($resp[5]);

            $store->code = $resp[0];
            $store->name = utf8_encode($resp[1]);
            $store->status = ($resp[7]=='Abierto') ? 1 : 0;
            $store->phonenumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($resp[12]));
            $store->email = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($resp[13]));
            $store->language = substr($resp[14],2);
            $store->contact = ($resp[15]=='SI') ? 1 : 0; 
            $store->client = ($client==null) ? 1 : $resp[5];

            $store->save();       

        }
        return back()->with('success','Upload stores successfuly!');
    }

    public function pushClients(Request $request) {
        
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $client = Client::find($resp[0]);

            if($client==null) {
                $client = new Client;
            }

            $client->id = $resp[0];
            $client->name = utf8_encode($resp[2]);
            $client->delegation = (strlen($resp[3])) ? 'ES' : $resp[3];
            $client->phonenumber = ($resp[5]==null) ? '617370097' : $resp[5];
            $client->email = ($resp[6]==null) ? 'daniel.molina@optimaretail.es' : $resp[6];
            $client->language = ($resp[17]==null || strlen($resp[17]) > 2) ? 'ES' : $resp[17];
            try { 
                //Your code
                $client->save();
               } catch(\Illuminate\Database\QueryException $ex){ 
                 dd($ex->getMessage()); 
               }
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
}
