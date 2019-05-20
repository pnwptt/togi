<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function loginForm()
    {
        if (session()->get('c_user') != null) {
            return redirect()->route(session()->get('admin') ? 'dashboard' : 'record');
        }
        return view('auth.login');
    }

    public function login(Request $req) 
    {
        $user = User::where('c_user', $req->c_user)->where('c_password', $req->c_password)->first();
        if ($user) {
            session()->put('c_user', $user->c_user);
            session()->put('admin', $user->isAdmin());
            
            return redirect()->route($user->isAdmin() ? 'dashboard' : 'record');
        } else {
            return redirect()->back()->with('error', 'Username or Password does not match our database.')->withInput($req->only('c_user'));;
        }
    }

    public function logout()
    {
        session()->forget('c_user');
        session()->forget('admin');
        return redirect()->route('login');
    }
}
