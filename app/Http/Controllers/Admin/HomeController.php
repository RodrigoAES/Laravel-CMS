<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Visitor;
use App\Models\Page;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $dateLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineCount = Visitor::select('ip')
                ->where('access_date', '>=', $dateLimit)
                ->groupBy('ip')
                ->count();
            $pagePie = [];
            $limit = $request->input('limit', '-30 days');
            if(!in_array($limit, ['-30 days', '-60 days', '-90 days', '-120 days'])) {
                $limit = '-120 days';
            }
            $dateLimit = date('Y-m-d H:i:s', strtotime($limit));
            $visitsAll = Visitor::selectRaw('page, count(page) as c')
                ->where('access_date', '>=', $dateLimit)
                ->groupBy('page')
                ->get();
            foreach($visitsAll as $visit) {
                $pagePie[$visit['page']] = intval($visit['c']);
            }

        return view('admin.home', [
            'visitsCount' => Visitor::where('access_date', '>=', $dateLimit)->count(),
            'onlineCount' => $onlineCount,
            'pagesCount' => Page::count(),
            'userCount' => User::count(),
            'pageLabels' => json_encode(array_keys($pagePie)),
            'pageData' => json_encode(array_values($pagePie)),
            'itemsColors' => array_keys($pagePie),
            'limit' => $limit
        ]);
    }
}
