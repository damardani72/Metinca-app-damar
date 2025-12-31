<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // Memanggil File 1 di atas
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller // Mewarisi sifat File 1
{
    use AuthenticatesUsers;

    /**
     * Kemana user akan diarahkan setelah login.
     */
    protected $redirectTo = '/sales';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}