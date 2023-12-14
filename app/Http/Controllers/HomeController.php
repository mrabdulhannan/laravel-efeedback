<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
    }

    public function definecategories()
    {
        return view('admin/definecategories');
    }

    public function mycategories()
    {
        return view('admin/mycategories');
    }

    public function newassesment()
    {
        return view('admin/newassesment');
    }

    public function previewpage()
    {
        return view('admin/previewpage');
    }

    public function updatepassword(){
        return view('admin/updatepassword');
    }
}
