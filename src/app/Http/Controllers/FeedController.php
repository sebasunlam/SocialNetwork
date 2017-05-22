<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Media;
use App\Models\PerfilLikePost;
use Illuminate\Http\Request;
use App\Models\Perfil;
use DB;
use App\User;
use Storage;
use Auth;

class FeedController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $id = Auth::user()->id;
        $currentuser = User::find($id);
        $mascotas = $currentuser->perfil->sigue()->orderBy("created_at", "desc")->get();


        $feeds = array();
        foreach ($mascotas as $mascota) {
            $posts = $mascota->post()->orderBy("created_at", "desc")->get();
            foreach ($posts as $post) {
                $feeds[] = $this->PostToFeed($post,$mascota);
            }
        }

        $misMascotas = $currentuser->perfil->mascota()->get();

        foreach ($misMascotas as $mascota) {
            $posts = $mascota->post()->orderBy("created_at", "desc")->get();
            foreach ($posts as $post) {
                $feeds[] = $this->PostToFeed($post,$mascota);
            }
        }

        $array = array_values(array_sort($feeds , function ($value) {
            return $value->timeStamp;
        }));

        $array = array_reverse(array_sort($array, function($value) {
            return $value->timeStamp;
        }));


        return view("feed.index")
            ->with("feeds",$array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
