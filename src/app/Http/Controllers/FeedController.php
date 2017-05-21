<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Media;
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

        $id = Auth::user()->id;
        $currentuser = User::find($id);
        $mascotas = $currentuser->perfil->sigue()->orderBy("created_at", "desc")->get();


        $feeds = array();
        foreach ($mascotas as $mascota) {
            $posts = $mascota->post()->orderBy("created_at", "desc")->get();
            foreach ($posts as $post) {
                $feeds[] = $this->MascotaToFeed($post,$mascota);
            }
        }

        $misMascotas = $currentuser->perfil->mascota()->get();

        foreach ($misMascotas as $mascota) {
            $posts = $mascota->post()->orderBy("created_at", "desc")->get();
            foreach ($posts as $post) {
                $feeds[] = $this->MascotaToFeed($post,$mascota);
            }
        }





        return view("feed.index")
            ->with("feeds", $feeds);
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


    private function MascotaToFeed($post,$mascota){

            $feed = new \stdClass();
            $feed->id = $post->id;
            $feed->petName = $mascota->nombre;
            $feed->timeStamp = $post->create_at;

            //Tratamiento media


            if (is_null($post->media_id)) {
                $feed->type = "texto";
            } else {
                $feed->type = "media";
                $media = Media::find($post->media_id);
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
            $likes = $post->likedBy()->orderBy("created_at", "desc")->get();
            foreach ($likes as $like) {
                $comments[] = $like->coment;
            }
            $feed->comments = $comments;
            $feed->icon = $mascota->raza->tipo->like_text;
            return $feed;


    }
}
