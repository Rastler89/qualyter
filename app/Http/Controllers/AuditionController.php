<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Audit;
use App\Models\Agent;

class AuditionController extends Controller
{
    public function viewAudit() {
        $audit = Audit::orderBy('id','desc')->get();

        return view('admin.audit.index',['audit' => $audit]);
    }

    public function viewLog() {
        return view('admin.log.index');
    }

    public function saveLog($old,$new,$type) {
        $log = new Log();
        $log->table = $type;
        $log->row_id = $old->id;
        $log->old = $old->status;
        $log->new = $new->status;
        $log->created = date('Y-m-d H:i');
        $log->save();
    }
}
