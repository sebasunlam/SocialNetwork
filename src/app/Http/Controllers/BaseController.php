<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\PerfilLikePost;
use Illuminate\Http\Request;
use Storage;

class BaseController extends Controller
{
    public function PostToFeed($post,$mascota){

        $feed = new \stdClass();
        $feed->id = $post->id;
        $feed->petId = $mascota->id;
        $feed->petName = $mascota->nombre;
        $feed->timeStamp = $post->created_at;
        $imagen = $mascota->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }
        $feed->petImage = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

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

        $likes=$post->perfil_like_post()->orderBy("created_at", "desc")->get();
        foreach ($likes as $like) {
            $comment = new \stdClass();
            $comment->comment = $like->coment;
            $comment->profileName =$like->perfil->nombre;
            $comment->profileId =$like->perfil->id;
            $comment->timeStamp =$like->created_at;
            $comment->like = $like->like;

            $imagen = $like->perfil->imagen()->latest()->first();


            $file = null;
            $extension = null;

            if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
                $file = Storage::get($imagen->url);
                $extension = $imagen->extension;
            }
            $comment->profileImage = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

            $comments[] = $comment;
        }
        $feed->comments = $comments;

        $feed->icon = $mascota->raza->tipo->like_text;

        return $feed;


    }
}
