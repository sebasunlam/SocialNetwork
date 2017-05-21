<?php
/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 20/05/2017
 * Time: 20:27
 */

namespace App\Http\Controllers;


use App\Models\Raza;

class RazaController extends Controller
{
    public function byTipo($tipo_id)
    {
        return Raza::where('tipo_id',$tipo_id)->get();
    }

}