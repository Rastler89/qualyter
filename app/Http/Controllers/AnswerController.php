<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Answer;
use App\Models\Store;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index() {
        $answers = Answer::all();
        $stores = Store::all();

        return view('admin.answer.index',['answers' => $answers, 'stores' => $stores]);
    }

    public function view($id) {
        $answer = Answer::find($id);
        $store = Store::where('code','=',$answer->store)->where('client','=',$answer->client)->first();
        $agents = Agent::all();
        $tasks = json_decode($answer->tasks);
        foreach($tasks as $task) {
            $owners[] = $task->owner;
        }

        $owners = Agent::find($owners);

        return view('admin.answer.view', ['answer' => $answer, 'store' => $store, 'agents' => $agents, 'owners' => $owners]);
    }
}
