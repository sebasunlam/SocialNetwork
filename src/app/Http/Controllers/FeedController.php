<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use App\Models\Perfil;
use DB;
use App\User;
use Storage;
use Auth;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $id = \Auth::user()->id;
        $currentuser = User::find($id);
        $mascotas = $currentuser->perfil->sigue()->orderBy("created_at", "desc");


        $feeds = array();
        foreach ($mascotas as $mascota) {
            $posts = $mascota->post()->orderBy("created_at", "desc");
            foreach ($posts as $post) {
                $feed = new \stdClass();
                $feed->petName = $mascota->nombre;
                $feed->timeStamp = $post->create_at;

                //Tratamiento media
                $media = $post->media();

                if (empty($media)) {
                    $feed->type = "texto";
                } else {
                    $feed->type = "media";

                    if ($media->local) {
                        $feed->mediaType = 'imagen';

                        if (Storage::disk('local')->exists($media->url)) {
                            $file = Storage::get($media->url);
                            $extension = $media->extension;
                        }
                        $feed->image = !empty($extension) && !empty($file) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;
                    } else {
                        $feed->mediaType = 'video';
                        $feed->url = $media->url;
                    }
                }
                //Fin tratamiento media

                $feed->content = $post->content;
                $comments = array();
                $likes = $post->likedBy()->orderBy("created_at", "desc");
                foreach ($likes as $like) {
                    $comments[] = $like->coment;
                }
                $feed->comments = $comments;
            }
            $feeds[] = $feed;
        }

        $id = Auth::user()->id;
        $currentuser = User::find($id);

        $imagen = $currentuser->perfil->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }

        //Profile data
        $perfil = $currentuser->perfil;
        $profile = new \stdClass();
        $profile->image = !empty($extension) && !empty($file) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;
        $profile->nombre = $perfil->nombre;
        $profile->apellido = $perfil->apellido;
        $profile->following = $currentuser->perfil->sigue()->count();

        //Followers Data
        $misMascotas = $currentuser->perfil->mascota();
        $followers = 0;
        foreach ($misMascotas as $miMascota){
            $followers+= $mascota->seguido()->count();
        }
        $profile->followers = $followers;
        return view("feed.index")
            ->with("feeds", $feeds)
            ->with("profile", $profile);
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
