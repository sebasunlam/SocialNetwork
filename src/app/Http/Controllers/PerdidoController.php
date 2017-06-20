<?php

namespace App\Http\Controllers;

use App\Models\Encontrado;
use App\Models\Imagen;
use App\Models\Mascota;
use App\Models\Perdido;
use Illuminate\Http\Request;
use DB;
use stdClass;
use Storage;

class PerdidoController extends BaseController
{
    //

    public function marcarPerdido(Request $request, $id)
    {
        return $this->tooglePerdido(true, $id, $request);
    }

    public function desmarcarPerdido(Request $request, $id)
    {
        return $this->tooglePerdido(fakse, $id, $request);
    }

    private function tooglePerdido($toogle, $id, $request)
    {
        $perfil = $this->getCurrentProfile();
        $mascota = $this->getMascotaPerfil($perfil, $id);

        if (!is_null($mascota)) {
            if ($toogle) {
                Perdido::create(["lat" => $request["lat"],
                        "long" => $request["long"],
                        "mascota_id" => $id]
                );
            }
            $mascota->update(["perdido" => $toogle]);
        } else {
            $errors = [];
            $errors[] = "La mascota no es de su pertenencia";
        }
    }

    public function hasEncontrados()
    {
        $perfil = $this->getCurrentProfile();
        $mascotas = Mascota::where("perdido", "=", 1)->where("perfil_id", "=", $perfil->id)->get();

        $tiene = "false";
        foreach ($mascotas as $mascota) {
            $perdido = $mascota->perdido()->orderBy("created_at", "desc")->first();
            if (Encontrado::where("perdido_id", "=", $perdido->id)->whereNull("aceptada")->count() > 0) {
                $tiene = "true";
            }
        }

        return $tiene;
    }

    public function getEncontrados()
    {
        $perfil = $this->getCurrentProfile();
        $mascotas = Mascota::where("perdido", "=", true)->where("perfil_id", "=", $perfil->id)->get();
        $mascotasViewModel = array();
        foreach ($mascotas as $mascota) {
            $perdido = $mascota->perdido()->orderBy("created_at", "desc")->first();
            $encontrados = Encontrado::where("perdido_id", "=", $perdido->id)->whereNull("aceptada")->get();

            if ($encontrados->count() > 0) {
                $mascotaViewModel = $this->MapToMascotaViewModel($mascota);
                $mascotaViewModel->encontrados = array();
                foreach ($encontrados as $encontrado) {
                    $encontradoViewModel = new stdClass();
                    $encontradoViewModel->contacto = $encontrado->contacto;
                    $encontradoViewModel->id = $encontrado->id;

                    $imagen = Imagen::where("id", "=", $encontrado->imagen_id)->first();


                    $file = null;
                    $extension = null;

                    if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
                        $file = Storage::get($imagen->url);
                        $extension = $imagen->extension;
                    }
                    $encontradoViewModel->imagen = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

                    if (is_null($encontrado->aceptada)){
                        $mascotaViewModel->encontrados[] = $encontradoViewModel;
                    }
                }
                $mascotasViewModel[] = $mascotaViewModel;
            }
        }

        return view("perdido.encontrados")->with("mascotasEncontradas", $mascotasViewModel);
    }

    public function acepta(Request $request, $encontradoId)
    {
        $encontrado = Encontrado::find($encontradoId);

        if ($request["acepta"] == "true") {

            $encontrado->update(["aceptada" => 1]);
            $perdido = Perdido::find($encontrado->perdido_id);
            $mascota = Mascota::find($perdido->mascota_id);
            $mascota->update(["perdido" => 0]);

            Encontrado::where("perdido_id", "=", $encontrado->perdido_id)->whereNull("aceptada")->update(["aceptada" => 0]);
        } else {
            $encontrado->update(["aceptada" => 0]);
        }
    }

    public function encontrado(Request $request)
    {

        DB::beginTransaction();

        $path = $request->photo->store('perdidos');

        if ($request->hasFile('photo') && $request->photo->isValid()) {
            $imagen = new Imagen([
                'url' => $path,
                'extension' => $request->photo->extension()
            ]);

            $imagen->save();

            Encontrado::create([
                "contacto" => $request["contacto"],
                "imagen_id" => $imagen->id,
                "perdido_id" => $request["perdido_id"]
            ]);

        }
        DB::commit();

        return redirect(route("perdido.all"));

    }

    public function getPerdidos()
    {
        $mascotas = Mascota::where("perdido", "=", 1)->get();
        $mascotasViewModel = array();


        foreach ($mascotas as $mascota) {
            $mascotaViewModel = $this->MapToMascotaViewModel($mascota);
            $perdido = $mascota->perdido()->orderBy("created_at", "desc")->first();
            $mascotaViewModel->lat = $perdido->lat;
            $mascotaViewModel->long = $perdido->long;
            $mascotaViewModel->perdidoId = $perdido->id;

            $mascotasViewModel[] = $mascotaViewModel;
        }

        return view("perdido.lista")->with("mascotas", $mascotasViewModel);
    }
}
