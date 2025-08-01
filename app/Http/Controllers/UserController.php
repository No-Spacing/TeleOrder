<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
        {
            if(Auth::user()->role_id == 3)
            {
                return redirect('/form');
            }
            else if(Auth::user()->role_id == 1)
            {
                return redirect('/records');
            }
            else if(Auth::user()->role_id == 4)
            {
                return redirect('/users');
            }
        } 
        else 
        {
            return back()->with(['message' => 'Invalid Credentials']);
        }
    }

    public function User(Request $request)
    {
        return inertia('Admin/User')
        ->with([
            'users' => User::with('role')
            ->where('name','LIKE', '%'.$request->search.'%')
            ->paginate(10),
            'roles' => Role::all(),
        ]);
    }

    public function SubmitUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id,
        ]);

        return redirect('/users')->with(['message' => 'User created successfully']);
    }

    public function SubmitUpdate(Request $request)
    {
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id
        ]);

        return redirect('/users')->with(['message' => 'User updated successfully']);
    }

    public function Logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
