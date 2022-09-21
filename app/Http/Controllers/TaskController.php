<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Agent;
use App\Models\Task;
use App\Models\Answer;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function new() {
        $stores = Store::all();
        $owners = Agent::all();
        return view('admin.workorder.create', ['stores' => $stores, 'owners' => $owners]);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'code' => 'required|unique:tasks',
            'name' => 'required',
            'expiration' => 'required',
            'priority' => 'required',
            'store' => 'required',
            'owner' => 'required'
        ]);

        $task = new Task;
        $task->code = $request->get('code');
        $task->name = utf8_encode($request->get('name'));
        $task->priority = utf8_encode($request->get('priority'));
        $task->owner = $request->get('owner');
        $task->store = $request->get('store');
        $task->expiration = date('Y-m-d h:i:s', strtotime(str_replace('/','-',$request->get('expiration'))));

        $task->save();

        $store = Store::where('code','=',$request->get('store'))->get();

        if($store != null && $store[0]->contact) {
            $answer = Answer::where('expiration','=',date('Y-m-d', strtotime(str_replace('/','-',$request->get('expiration')))))->where('store','=',$task->store)->where('client','=',$store[0]->client)->first();
            if($answer == null) {
                $answer = new Answer;
                $answer->expiration = date('Y-m-d', strtotime(str_replace('/','-',$request->get('expiration'))));
                $answer->status = 0;
                $answer->store = $task->store;
                $answer->client = ($store[0]->client==null || $store[0]->client=='') ? 1 : $store[0]->client;
            }
            $answer->token = Str::random(8);
            $answer->save();

            $answer->tasks()->save($task);

            return back()->with('success', 'New work order created and assign answer: '.$answer->id);
        }

        return back()->with('success', 'New work order created!');

    }

    
}
