<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_name', $user->name);
            
            return redirect()->route('admin.dashboard')->with('success', 'Hoş geldiniz, ' . $user->name);
        }

        return back()->withErrors([
            'email' => 'Email veya şifre hatalı.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('admin.login')->with('success', 'Başarıyla çıkış yaptınız.');
    }

    public function showChangePassword()
    {
        return view('admin.auth.change-password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Mevcut şifreniz yanlış.'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Log out user and redirect to login
        $request->session()->flush();

        return redirect()->route('admin.login')->with('success', 'Şifreniz başarıyla değiştirildi. Lütfen yeni şifrenizle giriş yapın.');
    }
}
