<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;


class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('can:edit-users');
    }

    public function index()
    {   
        
        $loggedId = Auth::id();
        $users = User::paginate(10);
        return view('admin.users.index', [
            'users' => $users,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'email', 'password', 'password_confirmation');
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
        ]);

        if($validator->fails()) {
            return redirect()->route('users.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user = User::find($id);
        if($user) {
            return view('Admin.users.edit', [
                'user' => $user
            ]);
        }
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

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
                return redirect()->route('users.edit', ['user'=>$id])
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
                    return redirect()->route('users.edit', ['user'=>$id])
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
                    return redirect()->route('users.edit', ['user'=>$id])
                        ->withErrors($validator)
                        ->withinput();
                }
                $user->password = Hash::make($data['password']);
            }

            $user->save();
            return redirect()->route('users.index');
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedId = Auth::id();

        if($loggedId !== intval($id)) {
            $user = User::find($id);
            $user->delete();
        }

        return redirect()->route('users.index');
    }
}
