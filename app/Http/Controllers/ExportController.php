<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function answer(Request $request) {
        $validated = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required', 
        ]);

        
    }
}
