<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Answer;


class ExportController extends Controller
{
    public function answer(Request $request) {
        $validated = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required', 
        ]);

        $headers = [
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'          => 'text/csv',
            'Content-Disposition'   => 'attachment; filename=answers.csv',
            'Expires'               => '0',
            'Pragma'                => 'public'
        ];

        $list = Answer::whereBetween('expiration', [$request->get('start_date'), $request->get('end_date')])->whereIn('status',array(2,4,5));
        
        if(!is_null($request->get('client')) && $request->get('client') != '') {
            $list->where('client','=',$request->get('client'));
        }
        if(!is_null($request->get('store')) && $request->get('store') != '') {
            $list->where('store','=',$request->get('store'));
        }
        
        $list = $list->get()->toArray();
        
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }
}
