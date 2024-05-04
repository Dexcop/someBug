<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function adminDashboard()
    {
        return view('admin_dashboard');
    }

    public function storeDashboard()
    {
        return view('store');
    }

    public function authenticate(Request $request)
    {
        $user = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // return view('dashboard', compact('data'));

        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            $dataController = new DataController();
            $data = $dataController->show();

            $data = $data->reverse();

            session(['data' => $data]);
            if (Auth::user()->isAdmin == true) {
                return redirect()->intended('admin_dashboard');
            } else {
                return redirect()->intended('dashboard');
            }
        }

        return back()->with('loginError', 'Login Failed');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}