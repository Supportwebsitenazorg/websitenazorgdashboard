<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuurzaamheidController extends Controller
{
    public function duurzaamheid($domain) {
        return view('monitoring.duurzaamheid', [
            'domain' => $domain
        ]);
    }
}
