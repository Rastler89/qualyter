<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Store;
use App\Models\Incidence;
use App\Models\Agent;
use App\Models\User;
use App\Models\Team;
use App\Models\Technician;
use Mail;
use App\Mail\ReminderAgent;
use App\Mail\ReminderManager;

class TestController extends Controller
{
    public function handle()
    {
        
        return view('public.technician');
    }

    public function post(Request $request) {

             
    }
}
