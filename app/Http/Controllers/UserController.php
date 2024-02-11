<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function delete(Request $request)
    {
        $user = Auth::user();
        
        if ($request->input('confirmation_name') !== $user->name) {
            return back()->with('error', __('messages.account_deletion_confirmation'));
        }
        
        $user->delete();
        Auth::logout();
        
        return redirect('/')->with('success', __('messages.account_deleted_success'));
    }
}
