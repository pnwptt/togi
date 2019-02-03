<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function login(Request $req) 
    {
        $user = User::where('c_user', $req->c_user)->where('c_password', $req->c_password)->first();
        if ($user) {
            session()->put('n_member', $user->n_member);
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Username or Password does not match our database.')->withInput($req->only('c_user'));;
        }
    }

    public function logout()
    {
        session()->forget('n_member');
        return redirect()->route('login');
    }
}
