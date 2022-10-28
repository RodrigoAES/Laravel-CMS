<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = User::find(Auth::id());
        if($user) {
            return view('Admin.profile.index', [
                'user' => $user
            ]);
        }

        return redirect()->route('admin');
    }

    public function save(Request $request)
    {
        $user = User::find(Auth::id());

        if($user) {
            $data = $request->only('name', 'email', 'password', 'password_confirmation');
            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ], [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255']
            ]);

            if($validator->fails()) {
                return redirect()->route('profile', ['user'=>Auth::id()])
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->name = $data['name'];

            if($user->email != $data['email']) {
                $validator = Validator::make([
                    'email' => $data['email']
                ], [
                    'email' => 'unique:users'
                ]);
                if($validator->fails()) {
                    return redirect()->route('profile', ['user'=>Auth::id()])
                        ->withErrors($validator)
                        ->withinput();
                } else {
                    $user->email = $data['email'];
                }
            }

            if(!empty($data['password'])) {
                $validator = Validator::make([
                    'password' => $data['password'],
                    'password_confirmation' => $data['password_confirmation']
                ], [
                    'password' => 'confirmed|min:4'
                ]);
                if($validator->fails()) {
                    return redirect()->route('profile', ['user'=>Auth::id()])
                        ->withErrors($validator)
                        ->withinput();
                }
                $user->password = Hash::make($data['password']);
            }

            $user->save();
            return redirect()->route('profile')->with('info', 'Informações alteradas com sucesso!');
        }
    }
}
