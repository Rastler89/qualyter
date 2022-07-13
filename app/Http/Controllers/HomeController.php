<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $answers = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d'))->get());
        $old_answers = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d',strtotime("-1 days")))->get());

        $porcentaje = number_format(($answers/$old_answers)*100-100,2);

        return view('home', ['total' => $answers, 'old_total' => $porcentaje]);
    }
}
