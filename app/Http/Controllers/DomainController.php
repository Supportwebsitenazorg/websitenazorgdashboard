<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function index()
    {
        $users = User::all();
        $allDomains = Domain::whereHas('users')->with('users')->get();
        $allOrganizations = Organization::whereHas('users')->with('users')->get();
    
        return view('domeinen', compact('users', 'allDomains', 'allOrganizations'));
    }
    
    public function assign(Request $request)
    {
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

        return back()->with('success', __('Domain added to the user.'));
    }
    
    public function assignOrganization(Request $request)
    {
        $request->validate([
            'user_email' => 'required|exists:users,email',
            'organization_name' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->user_email)->firstOrFail();
        $organizationName = $request->input('organization_name');
        
        $organization = Organization::firstOrCreate(['organization' => $organizationName]);

        if (!$user->organizations()->where('organization', $organizationName)->exists()) {
            $user->organizations()->attach($organization->OrganizationID);
        }

        return back()->with('success', __('Organization added to the user.'));
    }
}
