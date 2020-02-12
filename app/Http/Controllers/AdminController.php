<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\Index\AdminIndexRepositories;

class AdminController extends Controller {

    private $menuRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminIndexRepositories $menuRepository) {
        $this->middleware('auth');
        $this->menuRepository = $menuRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() 
    {
        return view('admin.index',['menus' => $this->menuRepository->getAllPaginate(10)]);
    }

    /**
     * A function that adds a new menu to the database. At the beginning it checks if a similar name already exists in the database so that it does not repeat.
     * @param Request $req
     * @return redirect
     */
    public function add(Request $request) 
    {        
        $this->menuRepository->create($request);
        return redirect()->back()->with('status', 'Added correctly!');
    }

    /**
     * Function to deleted menu from database
     * @param type $id
     * @return redirect 
     */
    public function delete($id) 
    {
        $this->menuRepository->delete($id);
        return redirect()->back()->with('status', 'Deleted correctly!');
    }

}
