<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'orgadmin') {
            abort(403);
        }

        $organizations = $user->organizations()->with(['domains.users'])->get();

        return view('manage', compact('organizations'));
    }
}
