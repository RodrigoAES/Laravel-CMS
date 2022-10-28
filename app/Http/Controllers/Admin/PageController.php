<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $pages = Page::paginate(10);
        return view('admin.pages.index', [
            'pages' => $pages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('title', 'body');

        $data['slug'] = Str::slug($data['title'], '-');

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['string'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages']
        ]);

        if($validator->fails()) {
            return redirect()->route('pages.create')
                ->withErrors($validator)
                ->withInput();
        }

        dd($data);
        $page = Page::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'body' => $data['body']
        ]);

        return redirect()->route('pages.index');
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
        $page = Page::find($id);
        if($page) {
            return view('Admin.pages.edit', [
                'page' => $page
            ]);
        }
        return redirect()->route('pages.index');
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
        $page = Page::find($id);

        if($page) {
            $data = $request->only('title', 'body');
            $validator = $page->title !== $data['title'] ? Validator::make([
                'title' => $data['title'],
                'body' => $data['body'],
                'slug' => Str::slug($data['title'], '-')
            ], [
                'title' => ['required', 'string', 'max:255'],
                'body' => ['string'],
                'slug' => ['required', 'string', 'max:255', 'unique:pages']

            ]) : Validator::make([
                'title' => $data['title'],
                'body' => $data['body']
            ], [
                'title' => ['required', 'string', 'max:255'],
                'body' => ['string', 'max:255']
            ]);

            if($validator->fails()) {
                return redirect()->route('pages.edit', ['page'=>$id])
                    ->withErrors($validator)
                    ->withInput();
            }

            $page->slug = $page->title === $data['title'] ? $page->slug : Str::slug($data['title'], '-'); 
            $page->title = $data['title'];
            $page->body = $data['body'];
            $page->save();

            return redirect()->route('pages.index');
        }

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();

        return redirect()->route('pages.index');
    }
}
