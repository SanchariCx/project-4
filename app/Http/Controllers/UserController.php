<?php

namespace App\Http\Controllers;
use Auth;
use Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
      }
}
