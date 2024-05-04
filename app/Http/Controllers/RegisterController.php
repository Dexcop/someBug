<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|unique:users|string|email|regex:/^[a-zA-Z0-9_.+-]+@gmail\.com$/',
            'password' => 'required|string|min:6|max:12',
            'phoneNumber' => 'required|string|regex:/^08[0-9]{8,10}$/',
            'isAdmin' => 'sometimes|boolean'
        ]);

        try {

            $validation['password'] = bcrypt($validation['password']);

            User::create($validation);

            return redirect('/login');
        } catch (QueryException $exception) {
            // Handle the error accordingly
            if ($exception->errorInfo[1] == 1062) {
                return back()->withErrors(['email' => 'The email has already been taken'])->withInput();
            }
            // Re-throw the exception if it's not a duplicate key issue
            throw $exception;
        }
    }

}