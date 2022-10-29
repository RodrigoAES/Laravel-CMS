<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Visitor;

class PageController extends Controller
{
    public function index(Request $request, $slug) {
        $page = Page::where('slug', $slug)->first();
        if($page) {
            Visitor::create([
                'ip' => $request->ip(),
                'access_date' => date('Y-m-d H:i:s'),
                'page' => $slug
            ]);
            return view('Site.page', [
                'page' => $page
            ]);

        } else {
            abort(404);
        }
    }
}
