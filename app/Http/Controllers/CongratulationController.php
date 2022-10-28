<?php

namespace App\Http\Controllers;

use App\Models\Congratulation;
use Illuminate\Http\Request;

class CongratulationController extends Controller
{
    public function create(Request $request)
    {
        $cong = new Congratulation();

        $cong->agent = $request->agent;
        $cong->client = $request->client;

        $cong->save();

        return redirect()->route('reports.congratulations')->with('success','New congratulation created');

    }

}
