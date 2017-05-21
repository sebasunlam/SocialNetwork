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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (\Auth::check()) {
            $id = Auth::user()->id;
            $currentuser = User::find($id);
            if ($currentuser->perfil == null){
                return view('perfil/create');
            }

             return redirect('feed');

        }


        return view('home');
    }


}
