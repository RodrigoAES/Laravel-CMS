<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LVR\Colour\Hex;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $data = Setting::all();
        foreach($data as $setting) {
            $settings["$setting->name"] = $setting['content'];
        }
        
        return view('Admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request) {
        $data = $request->only('title', 'subtitle', 'email', 'bgcolor', 'textcolor');
        
        $validator = $this->validator($data);
        if($validator->fails()) {
            return redirect()->route('settings')
                ->withErrors($validator);
        }

        foreach($data as $input => $value) {
            Setting::where('name', $input)->update([
                'content' => $value
            ]);
        }

        return redirect()->route('settings')
            ->with('info', 'Alterações salvas com sucesso!');
    }

    protected function validator($data) {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['string', 'max:255'],
            'email' => ['required', 'email', 'string'],
            'bgcolor' => ['string', new Hex],
            'textcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i']
        ]);
    }
}
