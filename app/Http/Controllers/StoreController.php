<?php


namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\Answer;
use Barryvdh\Debugbar\Facade as Debugbar;

class StoreController extends Controller
{
    public function index(Request $request) {

        $name = $request->query('name');
        $code = $request->query('code');

        if(!empty($name) || !empty($code)) {
            $pre_store = Store::query();
            if($name != '') {
                $pre_store->where('name','LIKE','%'.$name.'%');
            }
            if($code != '') {
                $pre_store->where('code','LIKE','%'.$code.'%');
            }
            $stores = $pre_store->sortable()->paginate(20);
        } else {
            $stores = Store::sortable()->paginate(20);
        }
        
        $clients = Client::all();
        return view('admin.store.index', ['stores' => $stores, 'clients' => $clients, 'filterName' => $name, 'filterCode' => $code]);
    }

    public function new() {
        $clients = Client::all();

        return view('admin.store.profile',['store' => null, 'clients' => $clients]);
    }


    public function create(Request $request) {
        Store::disableAuditing();
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

        if($request->get('contact') == 'on' && $request->get('whatsapp') == 'on'){
            $store->whatsapp = true;
        }else{
            $store->whatsapp = false;
        }
        
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

        if($request->get('contact') == 'on' && $request->get('whatsapp') == 'on'){
            $store->whatsapp = true;
        }else{
            $store->whatsapp = false;
        } 

        $store->save();
        
        //Si el estado contact pasa de TRUE a FALSE todas las Answwers con estado 0 o 1 pasarán automáticamente a estado 8

        if($store->contact != 1 ) {

            $answers = Answer::where('store', '=', $store->code)->whereIn('status',[0,1])->get();

            if(isset($answers)){
                foreach($answers as $answer){
                    $body = [];
                    $body['problem'] = 'No se ha podido contactar';
                    $answer->status = 8;
                    $answer->answer=json_encode($body,true);
                    $answer->user = null;
                    $answer->save();
                }
            }
            
        }else{
            $today = date("Y-m-d");
            $answers = Answer::where('store', '=', $store->code)->where('status', '!=', 0)->where('expiration', 'like', '%'.$today.'%')->get();
           
            if(isset($answers)){
                foreach($answers as $answer){
                    $answer->status = 0;
                    $answer->answer = null;    
                    $answer->save();
                }
            }
        }

        return redirect()->route('stores')->with('success','Store updted succesfully');
    }
}
