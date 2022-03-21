<?php

namespace App\Http\Controllers;

use App\Models\Incidence;
use Illuminate\Http\Request;

class IncidenceController extends Controller
{
    public function index() {
        $incidences = Incidence::all();

        return view('admin.incidence.index', ['incidences' => $incidences]);
    }
}
