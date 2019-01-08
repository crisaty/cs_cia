<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// EXTRAS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.default');
    }

    public function login(Request $request)
    {
      $user = User::where('email', $request->email)
              ->where('password', $request->password)
              ->first();

      if($user) {
          Auth::login($user);
          return redirect()->route('main');
      } else {
          return back()->withErrors(['password' => trans('auth.failed')]);
      }

    }

    public function logout(Request $request)
    {
      Auth::logout();
      $request->session()->invalidate();
      return redirect('/login');
    }

}
