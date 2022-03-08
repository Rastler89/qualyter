<?php

namespace App\Http\Controllers;

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
}
