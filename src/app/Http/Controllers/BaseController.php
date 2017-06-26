<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\PerfilLikePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
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

        $likes=$post->perfil_like_post()->orderBy("created_at", "asc")->get();

        $feed->commentsCounter = $likes->count();

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

        if(Auth::check()){
            $sigueMascota = Auth::user()->perfil->sigue()->find($mascota->id);
            $feed->canComment = !is_null($sigueMascota);
        }else{
            $feed->canComment = false;
        }


        return $feed;


    }


    public function getCurrentProfile(){
        if(Auth::check()){
            return Auth::user()->perfil;
        }

        return null;
    }

    public function getMascotaPerfil($perfil,$id){
        return $perfil->mascota()->find($id);
    }


    public function getMascotasFromLogedUser()
    {
        $mascotas = Auth::user()->perfil->mascota;

        $listMascotaViewModel = array();
        foreach ($mascotas as $mascota) {
           // dd($mascota);
            $listMascotaViewModel[] = $this->MapToMascotaViewModel($mascota);
        }
        return $listMascotaViewModel;
    }

    public
    function MapToMascotaViewModel($mascota)
    {
        $mascotaViewModel = new stdClass();
        $mascotaViewModel->id = $mascota->id;
        $mascotaViewModel->nombre = $mascota->nombre;
        $mascotaViewModel->dia_nacimiento = $mascota->dia;
        $mascotaViewModel->mes_nacimiento = $mascota->mes;
        $mascotaViewModel->anio_nacimiento = $mascota->anio;
        $mascotaViewModel->sexo_id = $mascota->sexo->id;
        $mascotaViewModel->tamanio_id = $mascota->tamanio->id;
        $mascotaViewModel->raza_id = $mascota->raza->id;
        $mascotaViewModel->tipo_id = $mascota->raza->tipo->id;
        $mascotaViewModel->adopcion = $mascota->adopcion;
        $mascotaViewModel->pareja = $mascota->cita;
        $mascotaViewModel->perdido = $mascota->perdido;
        $mascotaViewModel->like_text = $mascota->raza->tipo->like_text;

        /* parametricos detalle*/
        $mascotaViewModel->sexo = $mascota->sexo->descripcion;
        $mascotaViewModel->tipo = $mascota->raza->tipo->descripcion;
        $mascotaViewModel->raza = $mascota->raza->descripcion;
        $mascotaViewModel->tamanio = $mascota->tamanio->descripcion;
        $mascotaViewModel->en_adopcion = $mascota->adopcion ? "SI" : "NO";
        $mascotaViewModel->en_pareja = $mascota->cita ? "SI" : "NO";
        $mascotaViewModel->esta_perdido = $mascota->perdido ? "SI" : "NO";
        $mascotaViewModel->perdido = $mascota->perdido;
        $mascotaViewModel->buscandoPareja = $mascota->cita;
        $mascotaViewModel->adopcion = $mascota->adopcion;

        $imagen = $mascota->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }
        $mascotaViewModel->imagen = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

        if (empty($mascota->dia) && empty($mascota->mes)) {
            $mascotaViewModel->nacimiento = $mascota->anio;
        } elseif (empty($mascota->dia)) {
            $mascotaViewModel->nacimiento = $mascota->mes . "/" . $mascota->anio;
        } else {
            $mascotaViewModel->nacimiento = $mascota->dia . "/" . $mascota->mes . "/" . $mascota->anio;
        }


        return $mascotaViewModel;

    }

    public function notFound(){
        return view("shared.notfound");
    }
}
