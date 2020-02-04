<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menus'] = Menu::select('id','name','parent_id')->paginate(10);
        return view('home',$data);
    }
    
    /**
     * A function that adds a new menu to the database. At the beginning it checks if a similar name already exists in the database so that it does not repeat.
     * @param Request $req
     * @return redirect
     */
    public function menuAdd(Request $req)
    {        
        $req->validate(['name' => 'required|unique:menus|max:191']); 
        
        $menu = New Menu();
        $menu->name = $req->name;
        $menu->parent_id = $req->parent_id;
        $menu->slug = Str::slug($req->name);
        $menu->save();
        
        Cache::forget('menus_cache');
        
        return redirect()->back()->with('status','Added correctly!');
    }
    
    /**
     * Function to deleted menu from database
     * @param type $id
     * @return redirect 
     */
    public function menuDelete($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        
        Cache::forget('menus_cache');
        
        return redirect()->back()->with('status','Deleted correctly!');
    }
}
