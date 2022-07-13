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
        $total_today = count(Answer::where('expiration','=',date('Y-m-d'))->get());
        $finish_today = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d'))->get());
        $fisnih_yesterday = count(Answer::whereIn('status',[2,4,5])->where('expiration','=',date('Y-m-d',strtotime("-1 days")))->get());
        $porcentaje_finalizadas = number_format(($finish_today/$fisnih_yesterday)*100-100,2);
        $porcentaje_dia = number_format(($finish_today/$total_today)*100,2);

        return view('home', ['finish_today' => $finish_today, 'old_total' => $porcentaje_finalizadas, 'total' => $total_today, 'porcentaje_total' => $porcentaje_dia]);
    }
}
