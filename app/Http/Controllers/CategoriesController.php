<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function create(){
        return view('admin.definecategories');
    }

    public function store(Request $request){

        // var_dump($request);
        // exit();
        // $data = $request->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'group' => 'required',
        //  ]);

        $user = auth()->user();

        // Create a new post for the authenticated user
        $user->definecategories()->create([
            'title'=>$request['title'],
            'description'=>$request['description'],
            'group'=>$request['group'],
            'user_id'=> $user['id'],
        ]);

        return redirect('/definecategories');
    }
}
