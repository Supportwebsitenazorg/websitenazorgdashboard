<?php

namespace App\Http\Controllers;

use App\Models\Domain; // Make sure to use your actual Domain model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|unique:domains,domain', // Ensure the domain is unique in the domains table
        ]);

        $domain = new Domain;
        $domain->domain = $request->domain;
        $domain->user_id = Auth::id(); // Set the user_id to the ID of the authenticated user
        $domain->save();

        return redirect('/domeinen')->with('success', 'Domain added successfully.');
    }
}
