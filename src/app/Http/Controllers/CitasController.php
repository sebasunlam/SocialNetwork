<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use Illuminate\Http\Request;
use stdClass;

class CitasController extends BaseController
{
    //

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
        $mascotaPidiendo = $this->getMascotaPerfil($perfil, $request['mascota_pidiendo_id']);
        $mascotaBuscando = Mascota::find($request["mascota_buscando_id"]);
        $errors = [];

        if (is_null($mascotaPidiendo)) {
            $errors[] = "La mascota no es de su pertenencia";
        }

        if (is_null($mascotaBuscando)) {
            $errors[] = "La mascota no que busca la cita no existe";
        }

        if (!is_null($mascotaBuscando) && !$mascotaBuscando->cita) {
            $errors[] = "La mascota no que busca citas";
        }

        if ($mascotaPidiendo->citaOfrecida()->where("buscando", "=", $mascotaBuscando->id)) {
            $errors[] = "Usted ya realizo una solicitud a esta mascota";
        }

        if ($mascotaPidiendo->sexo_id == $mascotaBuscando->sexo_id) {
            $errors[] = "Ambas mascotas tienen el mismo sexo";
        }

        if (isEmpty($errors)) {
            Cita::create([
                "buscando" => $mascotaBuscando->id,
                "ofrecida" => $mascotaPidiendo->id
            ]);
            return vie("citas.busqueda")
                ->with("mascotas", $this->filterMascotas($request, $mascotaPidiendo))
                ->with("mascotaPidiendo", $mascotaPidiendo)
                ->with("mascotaBuscando", $mascotaBuscando);
        } else {
            return vie("citas.busqueda")->with("errors", $errors);
        }
    }



    public function busqueda(Request $request)
    {
        if($request["mascota_pidiendo_id"])
        $mascotaPidiendo = Mascota::find($request["mascota_pidiendo_id"]);

        if (is_null($mascotaPidiendo)) {
            $errors[] = "Debe especificar una mascota para ofrecer";
        }

        if (!isEmpty($errors)) {

            return vie("citas.busqueda")->with("mascotas", $this->filterMascotas($request, $mascotaPidiendo));

        } else {
            return vie("citas.busqueda")->with("errors", $errors);
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



    public function aceptarCita(Request $request){
        $cita = Cita::find($request["id"]);
        $perfil = $this->getCurrentProfile();

        foreach ($perfil->mascota() as $mascota){
            if($cita->buscando->id == $mascota->id){
                $cita->update(["acepta"=>$request["acepta"]]);
            }
        }

        return $request["acepta"];
    }

    private function getCitasVieModel()
    {
        $perfil = $this->getCurrentProfile();
        $mascotasCita = $perfil->mascota()->where("cita", "=", true);

        $citas = [];
        foreach ($mascotasCita as $mascota) {
            $ofrecimientos = $mascota->citaBuscando()->where("acepta", "=", null);
            foreach ($ofrecimientos as $ofrecimiento) {
                $cita = new stdClass();
                $cita->nombreOfrecido = $ofrecimiento->ofrecida->nombre;
                $cita->nombreBuscando = $mascota->nombre;
                $cita->raza = $ofrecimiento->raza->descripcion;
                $cita->tipo = $ofrecimiento->raza->tipo->descripcion;
                $cita->id = $ofrecimientos->id;

                $imagen = $ofrecimiento->ofrecida->imagen()->latest()->first();


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

        if (!isEmpty($request["raza_id"])) {
            $mascotas = $mascotas->where("raza_id", "=", $request["raza_id"]);
        }

        if (!isEmpty($request["tipo_id"])) {
            $mascotas = $mascotas->join("raza")->where("tipo_id", "=", $request["tipo_id"]);
        }

        if (!isEmpty($request["tamanio_id"])) {
            $mascotas = $mascotas->where("tamanio_id", "=", $request["tamanio_id"]);
        }

        $mascotas = $mascotas->where("sexo_id", "!=", $mascotaPidiendo->sexo_id);
        $mascotas = $mascotas->join("cita")->where("cita.ofrecida", "!=", $mascotaPidiendo->id);

        $mascotasViewModel = [];

        foreach ($mascotas as $mascota) {
            $mascotaViewModel = new stdClass();
            $mascotaViewModel->nombre = $mascota->nombre;
            $mascotaViewModel->raza = $mascota->raza->descripcion;
            $mascotaViewModel->tipo = $mascota->raza->tipo->descripcion;
            $mascotaViewModel->provincia = $mascota->perfil->domicilios->first()->localidad->departamento->provincia->descripcion;
            $mascotaViewModel->departamento = $mascota->perfil->domicilios->first()->localidad->departamento->descripcion;
            $mascotaViewModel->localidad = $mascota->perfil->domicilios->first()->localidad->descripcion;
            $mascotaViewModel->latlong = $mascota->perfil->domicilios->first()->lat . "," . $mascota->perfil->domicilios->first()->long;

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

            return vie("citas.index")->with("mascota", $mascota);
        } else {
            $errors = [];
            $errors[] = "La mascota no es de su pertenencia";
            return vie("shared.index")->with("errors", $errors);
        }
    }


}
