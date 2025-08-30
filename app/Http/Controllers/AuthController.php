<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
  public function showLogin() {
    return view('auth.login');
  }

  public function login(Request $r) {
    $r->validate(['username'=>'required','password'=>'required']);
    if(Auth::attempt(['username'=>$r->username,'password'=>$r->password])) {
      $r->session()->regenerate();
      return redirect()->route('rumah_sakit.index');
    }
    return back()->withErrors(['username'=>'Username atau password salah']);
  }

  public function logout(Request $r) {
    Auth::logout();
    $r->session()->invalidate();
    $r->session()->regenerateToken();
    return redirect()->route('login');
  }
}
