<?php

namespace App\Http\Composers;

use App\User;
use Auth;
use Illuminate\Contracts\View\View;
use stdClass;
use Storage;


class SidebarComposer
{
    public function compose(View $view)
    {

        if (Auth::check()) {

            $id = Auth::user()->id;
            $currentuser = User::find($id);
            if (!is_null($currentuser->perfil)) {
                $imagen = $currentuser->perfil->imagen()->latest()->first();


                $file = null;
                $extension = null;

                if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
                    $file = Storage::get($imagen->url);
                    $extension = $imagen->extension;
                }

                //Profile data
                $perfil = $currentuser->perfil;
                $profile = new stdClass();
                $profile->image = !empty($extension) && !empty($file) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;
                $profile->nombre = $perfil->nombre;
                $profile->apellido = $perfil->apellido;
                $profile->following = $currentuser->perfil->sigue()->count();

                //Followers Data
                $misMascotas = $currentuser->perfil->mascota()->get();
                $followers = 0;
                foreach ($misMascotas as $miMascota) {
                    $followers += $miMascota->seguido()->count();
                }
                $profile->followers = $followers;
                $profile->mascotas = $misMascotas;

                $view->with('profile', $profile);
            }

        }


    }
}