<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class ApiController extends Controller
{
    public function emails(Request $request) {
        $body = json_decode($request->getContent(), true);
        
        $answer = Answer::whereIn('status',[3,4]);

        if($body['start_date'] != null) {
            //tenemos fecha inicio
            if($body['end_date'] != null) {
                //tenemos fechas
                $answer->whereBetween('expiration',[$body['start_date'],$body['end_date']]);
            } else {
                //hasta fecha actual
                $answer->where('expiration','<=',$body['start_date']);
            }
        } else {
            if($body['end_date'] != null) {
                //tenemos fecha final
                $answer->where('expiration','>=',$body['end_date']);
            }
        }

        $answer->get();

        $response = [];
        //$response['total'] = count($answer);
        $response['body'] = $answer;

        echo json_encode($response);
    }
}
