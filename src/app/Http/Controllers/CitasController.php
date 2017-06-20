<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Domicilio;
use App\Models\Mascota;
use App\Models\Perfil;
use App\Models\Tamanio;
use Illuminate\Http\Request;
use stdClass;
use Storage;

class CitasController extends BaseController
{
    //
    public function hasCita()
    {
        $mascotas = $this->getMascotasFromLogedUser();
        $tiene = "false";
        foreach ($mascotas as $mascota) {

            if (Cita::where("buscando", "=", $mascota->id)->whereNull("acepta")->count() > 0)
                $tiene = "true";
        }

        return $tiene;
    }

    public function buscandoCita($id)
    {
        return $this->toogleCita(true, $id);
    }

    public function dejarDeBuscar($id)
    {
        return $this->toogleCita(false, $id);
    }

    public function pedirCita(Request $request)
    {
        $perfil = $this->getCurrentProfile();
        $mascotaPidiendo = $this->getMascotaPerfil($perfil, $request["mascota_pidiendo_id"]);

        $mascotaBuscando = Mascota::find($request["mascota_buscando_id"]);
        $errors = [];

        if (is_null($mascotaPidiendo)) {
            $errors[] = "La mascota no es de su pertenencia";
        }

        if (is_null($mascotaBuscando)) {
            $errors[] = "La mascota no que busca la cita no existe";
        }


        if (!is_null($mascotaBuscando) && !$mascotaBuscando->cita) {
            $errors[] = "La mascota no busca citas";
        }

        if ($mascotaPidiendo->sexo_id == $mascotaBuscando->sexo_id) {
            $errors[] = "Ambas mascotas tienen el mismo sexo";
        }

        if (empty($errors)) {
            Cita::create([
                "buscando" => $mascotaBuscando->id,
                "ofrecida" => $mascotaPidiendo->id
            ]);
        } else {
            return $errors;
        }
    }


    public function getBusquedaView()
    {
        $mascotas = $this->getMascotasFromLogedUser();

        return view("citas.busqueda")
            ->with("misMascotas", $mascotas)
            ->with("tamanios", Tamanio::all());
    }

    public function busqueda(Request $request)
    {
        if ($request["mascota_pidiendo_id"])
            $mascotaPidiendo = Mascota::find($request["mascota_pidiendo_id"]);

        $errors = array();
        if (is_null($mascotaPidiendo)) {
            $errors[] = "Debe especificar una mascota para ofrecer";
        }

        $mascotas = $this->getMascotasFromLogedUser();

        $model = new stdClass();
        $model->mascota_pidiendo_id = $request["mascota_pidiendo_id"];
        $model->raza_id = $request["raza_id"];
        $model->tamanio_id = $request["tamanio_id"];
        if (empty($errors)) {

            return view("citas.busqueda")
                ->with("mascotasCitas", $this->filterMascotas($request, $mascotaPidiendo))
                ->with("misMascotas", $mascotas)
                ->with("tamanios", Tamanio::all())
                ->with("model", $model);

        } else {
            return view("citas.busqueda")
                ->with("multipleErrors", $errors)
                ->with("misMascotas", $mascotas)
                ->with("tamanios", Tamanio::all())
                ->with("model", $model);
        }
    }

    public function notificacionCitas()
    {
        return $this->getCitasVieModel();

    }

    public function listadoCitas()
    {
        return view("citas.lista")->with("citas", $this->getCitasVieModel());
    }


    public function aceptarCita(Request $request)
    {
        $cita = Cita::find($request["id"]);
        $perfil = $this->getCurrentProfile();

        foreach ($perfil->mascota as $mascota) {

            if ($cita->buscando == $mascota->id) {

                $cita->update(["acepta" => $request["acepta"] ? 1 : 0]);
            }
        }

        return $request["acepta"];
    }

    private function getCitasVieModel()
    {
        $perfil = $this->getCurrentProfile();
        $mascotasCita = $perfil->mascota()->where("cita", "=", true)->get();

        $citas = [];
        foreach ($mascotasCita as $mascota) {

            $ofrecimientos = $mascota->citaBuscando()->where("acepta", "=", null)->get();


            foreach ($ofrecimientos as $ofrecimiento) {

                $cita = new stdClass();
                $ofrecido = Mascota::find($ofrecimiento->ofrecida);
                $cita->nombreOfrecido = $ofrecido->nombre;

                $cita->nombreBuscando = $mascota->nombre;
                $cita->raza = $ofrecido->raza->descripcion;
                $cita->tipo = $ofrecido->raza->tipo->descripcion;
                $cita->id = $ofrecimiento->id;

                $imagen = $ofrecido->imagen()->latest()->first();


                $file = null;
                $extension = null;

                if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
                    $file = Storage::get($imagen->url);
                    $extension = $imagen->extension;
                }
                $cita->imagenOfrecido = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

                $citas[] = $cita;
            }
        }

        return $citas;
    }

    private function filterMascotas(Request $request, $mascotaPidiendo)
    {

        $mascotas = Mascota::where("cita", "=", true);


        //$mascotas = $mascotas->where("raza.tipo_id", "=", $mascotaPidiendo->raza->tipo->id);

        if (!empty($request["raza_id"])) {

            $mascotas = $mascotas->where("mascota.raza_id", "=", $request["raza_id"]);
        }

        if (!empty($request["tamanio_id"])) {

            $mascotas = $mascotas->where("mascota.tamanio_id", "=", $request["tamanio_id"]);
        }


        $mascotas = $mascotas->where("mascota.sexo_id", "!=", $mascotaPidiendo->sexo_id);

        //$mascotas = $mascotas->join("cita","cita.buscando","=","mascota.id")->where("cita.ofrecida", "!=", $mascotaPidiendo->id);

        $mascotasViewModel = [];

        foreach ($mascotas->get() as $mascota) {
            $mascotaViewModel = new stdClass();
            $mascotaViewModel->nombre = $mascota->nombre;
            $mascotaViewModel->raza = $mascota->raza->descripcion;
            $mascotaViewModel->tipo = $mascota->raza->tipo->descripcion;
            $mascotaViewModel->id = $mascota->id;

            $domicilio = Domicilio::where("perfil_id", "=", $mascota->perfil->id)->first();

            $mascotaViewModel->provincia = $domicilio->localidad->departamento->provincia->descripcion;
            $mascotaViewModel->departamento = $domicilio->localidad->departamento->descripcion;
            $mascotaViewModel->localidad = $domicilio->localidad->descripcion;
            $mascotaViewModel->latlong = $domicilio->lat . "," . $domicilio->long;

            $mascotaViewModel->existeCita = Cita::where("ofrecida", "=", $mascotaPidiendo->id)->where("buscando", "=", $mascota->id)->whereNull("acepta")->count() > 0;

            $imagen = $mascota->imagen()->latest()->first();
            $file = null;
            $extension = null;

            if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
                $file = Storage::get($imagen->url);
                $extension = $imagen->extension;
            }
            $mascotaViewModel->imagen = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

            if ($mascotaPidiendo->raza->tipo->id == $mascota->raza->tipo->id)
                $mascotasViewModel[] = $mascotaViewModel;
        }
        return $mascotasViewModel;
    }

    private function toogleCita($toogle, $id)
    {
        $perfil = $this->getCurrentProfile();
        $mascota = $this->getMascotaPerfil($perfil, $id);
        if (!is_null($mascota)) {
            $mascota->update(["cita" => $toogle]);
        } else {
            $errors = [];
            $errors[] = "La mascota no es de su pertenencia";
        }
    }


}
