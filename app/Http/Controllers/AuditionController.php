<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function viewAudit() {
        return view('admin.audit.index');
    }

    public function viewLog() {
        return view('admin.log.index');
    }
}
