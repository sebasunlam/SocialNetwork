<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Perfil;
use App\Models\Transferencia;
use DB;
use Illuminate\Http\Request;

class AdopcionController extends BaseController
{
    //

    public function ponerAdpocion($id)
    {
        $this->toogleAdopcion(true, $id);
    }

    public function quitarAdopcion($id)
    {
        $this->toogleAdopcion(false, $id);
    }

    private function toogleAdopcion($toogle, $id)
    {
        $perfil = $this->getCurrentProfile();
        $mascota = $this->getMascotaPerfil($perfil, $id);

        if (!is_null($mascota)) {
            $mascota->update(["adopcion" => $toogle]);
        } else {
            return "La mascota no es de su pertenencia";
        }
    }

    public function tieneSoclicitudes()
    {
        $perfil = $this->getCurrentProfile();
        $mascotas = Mascota::where("adopcion", "=", 1)->where("perfil_id", "=", $perfil->id)->get();

        $tiene = "false";
        foreach ($mascotas as $mascota) {
            if (Transferencia::where("mascota_id", "=", $mascota->id)->whereNull("aceptada")->count() > 0) {
                $tiene = "true";
            }
        }

        return $tiene;
    }

    public function getEnAdopcion()
    {
        $mascotas = Mascota::where("adopcion", "=", 1)->get();
        $mascotasViewModel = array();
        $perfil = $this->getCurrentProfile();
        foreach ($mascotas as $mascota) {

            $mascotaViewModel = $this->MapToMascotaViewModel($mascota);
            $transeferencias = Transferencia::where("perfil_id", "=", $perfil->id)->get();
            $mascotaViewModel->existe = false;
            foreach ($transeferencias as $transeferencia) {
                if ($transeferencia->mascota_id == $mascota->id && $transeferencia->perfil_id == $perfil->id && is_null($transeferencia->aceptada)) {
                    $mascotaViewModel->existe = true;
                }
            }
            $propietario = false;
            foreach ($perfil->mascota as $miMascota) {
                if ($mascota->id == $miMascota->id) {
                    $propietario = true;
                }
            }
            if (!$propietario) {
                $mascotasViewModel[] = $mascotaViewModel;
            }
        }

        return view("adopcion.lista")->with("mascotasAdopcion", $mascotasViewModel);
    }

    public function solicitarTransferencia($mascotaId)
    {
        $mascota = Mascota::find($mascotaId);
        $perfil = $this->getCurrentProfile();
        if ($mascota->adopcion && $mascota->perfil->id != $perfil->id) {
            Transferencia::create([
                'perfil_id' => $perfil->id,
                'mascota_id' => $mascotaId
            ]);
        }
    }

    public function getSolicitudes()
    {
        $perfil = $this->getCurrentProfile();
        $mascotasAdopcion = $perfil->mascota->where("adopcion", "=", 1);
        $mascotasViewModel = array();
        foreach ($mascotasAdopcion as $mascota) {
            $transferencia = $mascota->transferencia()->whereNull('aceptada');
            if ($transferencia->count() > 0) {
                foreach ($transferencia->get() as $solicitud) {
                    $mascotaViewModel = $this->MapToMascotaViewModel($mascota);
                    $mascotaViewModel->perfilNombre = $solicitud->perfil->apellido . ", " . $solicitud->perfil->nombre;
                    $mascotaViewModel->solicitanteId = $solicitud->perfil->id;
                    $mascotaViewModel->transferenciaId = $solicitud->id;
                    $mascotasViewModel[] = $mascotaViewModel;
                }

            }
        }

        return view("adopcion.solicitudes")->with("mascotasSolicitudesAdopcion", $mascotasViewModel);


    }

    public function aceptaRechazaTransferencia(Request $request, $transferenciaId)
    {
        $transferencia = Transferencia::find($transferenciaId);

        $mascotas = $this->getMascotasFromLogedUser();
        foreach ($mascotas as $mascota) {
            if ($transferencia->mascota->id == $mascota->id) {


                if ($request["aceptada"] == "true") {
                    $transferencia->update(["aceptada" => 1]);
                    $mascotaTransferir = Mascota::find($transferencia->mascota_id);
                    $mascotaTransferir->update([
                        "perfil_id" => $transferencia->perfil_id,
                        "adopcion" => 0
                    ]);
                    Transferencia::where("mascota_id", "=", $mascota->id)->whereNull("aceptada")->update(["aceptada" => 0]);
                    DB::delete("DELETE FROM mascota_perfil WHERE mascota_id=" . $mascota->id . " AND perfil_id=" . $transferencia->perfil_id);
                } else {
                    $transferencia->update(["aceptada" => 0]);
                }
            }
        }
    }
}
