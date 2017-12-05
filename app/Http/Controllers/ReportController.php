<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparePart;

class ReportController extends Controller
{
    public function index()
    {
        $spare_parts = SparePart::all();
        return view('reports.index')->with('spare_parts', $spare_parts);
    }
}
