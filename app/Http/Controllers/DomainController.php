<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain; // Zorg ervoor dat u uw Domain-model importeert
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Auth::user()->domains ?? collect(); // Dit zorgt ervoor dat $domains altijd een collectie is
        return view('domeinen', compact('domains'));
    }
    

    public function add(Request $request)
    {
        $request->validate([
            'domain_name' => 'required|string|max:255',
        ]);
    
        // Assuming 'name' is the correct column in your domains table where you store the domain name
        $domain = Domain::firstOrCreate(['domain' => $request->domain_name]);
    
        // Here, we should not use $domain->id since the primary key of the domain is 'PropertyID'
        // Replace $domain->id with $domain->PropertyID
        if (!Auth::user()->domains()->find($domain->PropertyID)) {
            // Again, use $domain->PropertyID instead of $domain->id
            Auth::user()->domains()->attach($domain->PropertyID);
        }
    
        return back()->with('success', 'Domein toegevoegd aan uw account.');
    }    
}
