<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function show($domain)
    {
        return view('monitoring.show', compact('domain'));
    }
}
