<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;

class HomeController extends Controller
{
    public function index(Request $request) {
        Visitor::create([
            'ip' => $request->ip(),
            'access_date' => date('Y-m-d H:i:s'),
            'page' => 'Home'
        ]);
        return view('site.home');
    }
}
