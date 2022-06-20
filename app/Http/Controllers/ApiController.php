<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class ApiController extends Controller
{
    public function emails(Request $request) {
        $body = json_decode($request->getContent(), true);
        
        $answers = Answer::whereIn('status',[3,4]);

        $answers = $this->dating($body,$answers);

        $answers = $answers->get();

        $res = [];
        $res['total'] = count($answers);

        if($body['not_respond']) {
            $responds = Answer::where('status','=',3);
            $responds = $this->dating($body,$answers);
            $res['not_respond'] = count($responds);
        }
        foreach($answers as $answer) {
            $res['body'][] = $answer;
        }

        echo json_encode($res);
    }

    private function dating($body,$answers)  {
        if($body['start_date'] != null) {
            //tenemos fecha inicio
            if($body['end_date'] != null) {
                //tenemos fechas
                $answers->whereBetween('expiration',[$body['start_date'],$body['end_date']]);
            } else {
                //hasta fecha actual
                $answers->where('expiration','<=',$body['start_date']);
            }
        } else {
            if($body['end_date'] != null) {
                //tenemos fecha final
                $answers->where('expiration','>=',$body['end_date']);
            }
        }

        return $answers;
    }
}
