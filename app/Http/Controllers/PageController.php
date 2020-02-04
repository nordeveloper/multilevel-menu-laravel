<?php

namespace App\Http\Controllers;

use App\Menu;

class PageController extends Controller
{
    /**
     * Show the aplication dashboard
     * @return type
     */
    public function index()
    {
        return view('welcome');
    }
    
    /**
     * Show page template
     * @param type $slug
     * @return type
     */
    public function page($slug)
    {
        $page = Menu::where('slug',$slug)->first();
        if(!$page) abort(404);
        return view('page',['page' => $page]);
    }
}
