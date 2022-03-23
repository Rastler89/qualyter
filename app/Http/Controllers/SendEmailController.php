<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Mail;
use App\Mail\NotifyMail;
 
class SendEmailController extends Controller
{
     
    public function sendEmail() {
        Mail::to('daniel.molina@optimaretail.es')->locale('es')->send(new NotifyMail());
        echo"OK";
    } 
}