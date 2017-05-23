<?php

namespace App\Http\Controllers;


use App\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            $id = Auth::user()->id;
            $currentuser = User::find($id);
            if ($currentuser->perfil == null) {
                return view('perfil/create');
            }

            return redirect(route('feed'));

        }


        return view('welcome');
    }


}
