<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function privacy($domain) {
        return view('monitoring.privacy', ['domain' => $domain]);
    }
}
