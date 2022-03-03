<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Store;
use App\Models\Task;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index() {
        return view('admin.uploads.index');
    }

    public function pushTasks(Request $request) {

        $respuesta = $this->exportCSV($request, false);

        foreach($respuesta as $resp) {
            $task = new Task;

            $task->code = $resp[0];
            $task->name = $resp[1];
            $task->expiration = $resp[4];
            $task->status = 0;
            $task->priority = $resp[12];
            $task->owner = $resp[8];
            $task->store = $resp[17];
            $task->description = $resp[26];

            $task->save();
        }

        return back()->with('success','Upload tasks successfuly!');
    }
    
    public function pushAgents(Request $request) {

        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $agent = new Agent;

            $agent->name = htmlentities($resp[0], ENT_QUOTES, 'UTF-8', false);
            $agent->email = $resp[1];

            $agent->save();
        }
        return back()->with('success','Upload agents successfuly!');
    }

    public function pushStores(Request $request) {
        
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $store = new Store;

            $store->code = $resp[0];
            $store->name = htmlentities($resp[1], ENT_QUOTES, 'UTF-8', false);
            $store->status = ($resp[7]=='Abierto') ? 1 : 0;
            $store->phonenumber = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', trim($resp[12]));
            $store->email = $resp[13];
            $store->language = substr($resp[14],2);
            $store->contact = ($resp[15]=='SI') ? 1 : 0; 
            $store->client = $resp[5];

            $store->save();       
        }
        return back()->with('success','Upload clients successfuly!');
    }

    public function pushClients(Request $request) {
        
        $respuesta = $this->exportCSV($request);

        foreach($respuesta as $resp) {
            $client = new Client;

            $client->id = $resp[0];
            $client->name = $resp[2];
            $client->delegation = $resp[3];
            $client->phonenumber = $resp[5];
            $client->email = $resp[6];
            $client->language = $resp[17];
            
            $client->save();
        }

        return back()->with('success','Upload clients successfuly!');
        
    }

    private function exportCSV(Request $request, $header = true) {
        $file = $request->file('file');

        $name = $request->file('file')->getClientOriginalName();
        
        $file->move(storage_path(),$name);

        $response = [];
        //print_r(storage_path());
        if(($open = fopen(storage_path().'/'.$name,'r')) !== FALSE) {
            while(($data = fgetcsv($open,1000,';')) !== FALSE) {
                $response[] = $data;
            }
            fclose($open);
        }
        if($header) {
            unset($response[0]);
        }
        return $response;
    }
}
