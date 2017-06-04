<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use DB;
use stdClass;

class RankingController extends Controller
{
    //

    public function rannkingMascotaTipo($tipo)
    {
        return $this->generarRanking($tipo);
    }

    public function rannkingMascota()
    {

        return $this->generarRanking(null);
    }


    private function generarRanking($tipo)
    {
        $visitas = DB::select("SELECT COUNT(*) AS 'total',mascota_id FROM visita GROUP BY mascota_id");
        $likes = DB::select("SELECT COUNT(*) AS 'total',mascota_id FROM perfil_like_post l JOIN post p ON p.id = l.post_id WHERE 'like'=1 GROUP BY mascota_id");


        $ranking = [];
        foreach (Mascota::all() as $mascota) {
            $mascotaRankeada = new stdClass();

            $mascotaRankeada->total = 0;
            foreach ($visitas as $visita) {
                if ($visita->mascota_id == $mascota->id) {
                    $mascotaRankeada->total = $mascotaRankeada->total + $visita->total;
                    break;
                }
            }

            foreach ($likes as $like) {
                if ($like->mascota_id == $mascota->id) {
                    $mascotaRankeada->total = $like->total + $mascotaRankeada->total;
                    break;
                }
            }


            $mascotaRankeada->total = $mascotaRankeada->total + $mascota->seguido()->count();
            $mascotaRankeada->nombre = $mascota->nombre;
            $mascotaRankeada->mascota_id = $mascota->mascota_id;
            $mascotaRankeada->like_text = $mascota->raza->tipo->like_text;

            if (!is_null($tipo)) {
                if ($tipo == $mascota->raza->tipo->id) {
                    $ranking[] = $mascotaRankeada;
                }
            } else {
                $ranking[] = $mascotaRankeada;
            }
        }

        usort($ranking, function ($a, $b) {
            if ($a->total == $b->total) {
                return 0;
            }
            return ($a->total > $b->total) ? -1 : 1;
        });

        return array_slice($ranking, 0, 10);
    }
}
