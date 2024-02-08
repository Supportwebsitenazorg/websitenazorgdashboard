<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $users = User::all();
    
        $allDomains = Domain::whereHas('users')->with('users')->get();
    
        return view('domeinen', compact('users', 'allDomains'));
    }
    
    
    public function assign(Request $request)
    {
        \Log::debug('Assign method called');
        $request->validate([
            'user_email' => 'required|exists:users,email',
            'domain_name' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->user_email)->firstOrFail();
        $domainName = $request->input('domain_name');
        
        $domain = Domain::firstOrCreate(['domain' => $domainName]);

        if (!$user->domains()->where('domain', $domainName)->exists()) {
            $user->domains()->attach($domain->PropertyID);
        }

        return back()->with('success', 'Domein toegevoegd aan de gebruiker.');
    }
    
}
