<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();

        if ($user->role === 'admin') {
            $allDomains = Domain::with('users')->get();
            $allOrganizations = Organization::with('users')->get();
        } else {
            $allDomains = Domain::whereHas('organization', function ($query) use ($user) {
                $query->whereIn('OrganizationID', $user->organizations->pluck('OrganizationID'));
            })->with('users')->get();

            $allOrganizations = $user->organizations;
        }

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

        DB::beginTransaction();
        try {
            if (!$user->organizations()->where('organization', $organizationName)->exists()) {
                $user->organizations()->attach($organization->OrganizationID);
                $user->assignOrgAdminRole();
            }

            DB::commit();
            return back()->with('success', __('Organization added to the user.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('An error occurred while assigning the organization.'));
        }
    }
}
