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
        $users = User::where('role', '!=', 'admin')->get();

        if ($user->role === 'admin') {
            $allDomains = Domain::with('users')->get();
            $allOrganizations = Organization::with('users')->get();
        } else {
            $allDomains = Domain::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->orWhereHas('organization.users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('users')->get();

            $allOrganizations = $user->organizations;
        }

        return view('domeinen', compact('users', 'allDomains', 'allOrganizations'));
    }

    public function getOrganizationDomains($organizationId)
    {
        $domains = Domain::where('OrganizationID', $organizationId)->with('users')->get();
        return response()->json($domains);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_email' => 'required|exists:users,email',
            'domain_name' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->user_email)->firstOrFail();
        $domainName = $request->input('domain_name');

        $domain = Domain::where('domain', $domainName)->first();

        if (!$domain) {
            return back()->with('error', __('The domain does not exist.'));
        }

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

        $organization = Organization::where('organization', $organizationName)->first();

        if (!$organization) {
            return back()->with('error', __('The organization does not exist.'));
        }

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

    public function removeUserFromDomain(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $domain = Domain::where('domain', $request->domain)->first();

        if ($user && $domain) {
            $domain->users()->detach($user->id);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid user or domain']);
    }

    public function removeUserFromOrganization(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $organization = Organization::where('organization', $request->organization)->first();

        if ($user && $organization) {
            $organization->users()->detach($user->id);

            if ($user->organizations()->count() == 0) {
                $user->revokeOrgAdminRole();
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid user or organization']);
    }
}
