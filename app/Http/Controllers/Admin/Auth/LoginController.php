<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/painel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('Admin.login');
    }

    public function authenticate(LoginRequest $req) {
        $data = $req->only('email', 'password');

        $remember = $req->input('remember', false);

        if(Auth::attempt($data, $remember)) {
            return redirect()->route('admin');
        } else {
            return redirect()->route('login')
                ->withErrors(['password', 'E-mail e/ou senha incorretos'])
                ->withInput();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
