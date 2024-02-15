<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $organizations = $user->organizations()->with(['domains.users'])->get();

        return view('manage', compact('organizations'));
    }

    public function removeUserFromDomain(Request $request)
    {
        $orgAdmin = Auth::user();

        if ($orgAdmin->role !== 'orgadmin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $domain = Domain::where('domain', $request->domain)->first();

        if (!$domain) {
            return response()->json(['success' => false, 'message' => 'Domain not found'], 404);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $userInDomain = $domain->users()->where('users.id', $user->id)->exists();

        if (!$userInDomain) {
            return response()->json(['success' => false, 'message' => 'User not associated with the domain'], 404);
        }

        $domain->users()->detach($user->id);

        return response()->json(['success' => true, 'message' => 'User removed from domain']);
    }

    public function addUserToDomain(Request $request)
    {
        $orgAdmin = Auth::user();
    
        if ($orgAdmin->role !== 'orgadmin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
    
        $domain = Domain::where('domain', $request->domain)->first();
    
        if (!$domain) {
            return response()->json(['success' => false, 'message' => 'Domain not found'], 404);
        }
    
        // Check if user exists before attaching to domain
        $user = User::where('email', $request->user_email)->first();
    
        if (!$user) {
            // Return a response indicating the user does not exist
            return back()->with('error', 'User does not exist.');
        }
    
        // Check if user is already associated with the domain
        $userInDomain = $domain->users()->where('users.id', $user->id)->exists();
        if ($userInDomain) {
            // Return a response indicating the user is already in the domain
            return back()->with('error', 'User is already associated with this domain.');
        }
    
        // Attach the user to the domain
        $domain->users()->attach($user->id);
    
        return back()->with('success', 'User added to domain successfully.');
    }
    

}
