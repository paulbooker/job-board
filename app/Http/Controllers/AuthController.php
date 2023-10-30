<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	    //HERE
	    $request->validate([
			'email' => 'required|email',   
			'password' => 'required'
        ]); 
		//NOT HERE
        $credentials = $request->only('email', 'password'); 
        $remember = $request->filled('remember');  
        
        //$credentials = ['email' => 'paul@paulbooker.co.uk', 'password' => 'password'];
        //$remember = true;
        
        if (Auth::attempt($credentials, $remember)) { 
	    	return redirect()->intended('/');
        } else {  
	        return redirect()->back()
	        	->with('error', 'Invalid credentials');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/');
    }
}
