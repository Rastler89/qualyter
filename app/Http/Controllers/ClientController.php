<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::sortable()->paginate(25);

        return view('admin.client.index',['clients' => $clients]);
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

        $client->save();
        
        return redirect()->route('clients')->with('success','Client updated successfuly!');
    }
}
