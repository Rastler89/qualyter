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
       // $total_today = count(Answer::where('expiration','=',date('Y-m-d'))->get());
        //$porcentaje_dia = number_format(($finish_today/$total_today)*100,2);

        return view('home');
    }
}
