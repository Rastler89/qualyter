<?php


namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index() {
        $stores = Store::sortable()->paginate(20);
        $clients = Client::all();
        return view('admin.store.index', ['stores' => $stores, 'clients' => $clients]);
    }

    public function new() {
        $clients = Client::all();

        return view('admin.store.profile',['store' => null, 'clients' => $clients]);
    }


    public function create(Request $request) {
        $validated = $request->validate([
            'code' => 'required|unique:stores',
            'name' => 'required',
            'email' => 'required',
            'client' => 'required',
        ]);

        $url = 'https://restcountries.com/v2/name/'.str_replace(' ','%20',$request->get('country'));

        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp);
        
        $store = new Store;
        $store->code = $request->get('code');
        $store->name = $request->get('name');
        $store->status = ($request->get('status') == 'on') ? true : false;
        $store->phonenumber = $request->get('phonenumber');
        $store->email = $request->get('email');
        $store->client = $request->get('client');
        $store->contact = ($request->get('contact') == 'on') ? true : false;
        $store->language = $resp[0]->languages[0]->iso639_1;

        $store->save();

        return redirect()->route('stores')->with('success','Store added succesfully');
    }

    public function edit($id) {
        $id = str_replace('_','/',$id);
        $clients = Client::all();
        $store = Store::where('code','=',$id)->first();

        return view('admin.store.profile',['store' => $store, 'clients' => $clients]);

    }

    public function update(Request $request, $id) {
        $id = str_replace('_','/',$id);
        $clients = Client::all();
        $store = Store::where('code','=',$id)->first();

        if($request->get('country') != '--') {
            $url = 'https://restcountries.com/v2/name/'.str_replace(' ','%20',$request->get('country'));
    
            $curl = curl_init($url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
    
            $resp = curl_exec($curl);
            curl_close($curl);
            $resp = json_decode($resp);
            
            $store->language = $resp[0]->languages[0]->iso639_1;
        }
        
        $store->code = $request->get('code');
        $store->name = $request->get('name');
        $store->status = ($request->get('status') == 'on') ? true : false;
        $store->phonenumber = $request->get('phonenumber');
        $store->email = $request->get('email');
        $store->client = $request->get('client');
        $store->contact = ($request->get('contact') == 'on') ? true : false;

        $store->save();

        return redirect()->route('stores')->with('success','Store updted succesfully');
    }
}
