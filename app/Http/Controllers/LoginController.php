<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function Tampillogin()
    {
        return view('tools.login');
    }

    public function postlogin(Request $request)
    {
        if(Auth::attempt(

            [
                'email' => $request->email,
                'password' => $request->password,
            ]

        )){
            return redirect('dashboard');
        }
        return redirect('login');   
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
