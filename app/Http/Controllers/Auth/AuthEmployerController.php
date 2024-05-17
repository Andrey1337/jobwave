<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthEmployerController extends Controller
{
   
    public function showAuthFormEmp()
    {
        return view('auth.login_employer');
    }
    public function login(Request $request)
    {
        // Авторизация пользователя
        $credentials = $request->only('email', 'password');

        if (Auth::guard('company')->attempt($credentials)) {
            return redirect()->intended('/dashboard_employer');
        } else {
            return back()->withErrors(['email' => 'Неверный адрес электронной почты или пароль.']);
        }
    }

    public function logout(Request $request)
    {
        // Выход из аккаунта
        Auth::guard('company')->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
