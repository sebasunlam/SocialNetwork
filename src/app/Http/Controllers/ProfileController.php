<?php

namespace App\Http\Controllers;

use App\Models\Domicilio;
use Illuminate\Http\Request;
use App\Models\Provincia;
use App\Models\Perfil;
use App\Models\Sexo;
use App\User;
use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = \Auth::user()->id;
        $currentuser = User::find($id);

        $profile = $currentuser->perfil;

        if (empty($profile))
            return redirect()->route('profile.create');


        return redirect()->route('profile.edit');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = \Auth::user()->id;
        $currentuser = User::find($id);

        $perfil = $currentuser->perfil;
        if (!empty($perfil))
            return redirect()->route('profile.edit');

        return view('perfil.create')->with('sexos', Sexo::all())->with('provincias', Provincia::all());

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

$this->createUpdate($request,false);
//        $request = $request->all();
//
//        $id = \Auth::user()->id;
//        $currentuser = User::find($id);
//
//
//        $perfil = new Perfil([
//            'nombre' => $request['nombre'],
//            'apellido' => $request['apellido'],
//            'telefono' => $request['telefono'],
//            'fechanacimiento' => $request['fechanacimiento'],
//            'sexo_id' => $request['sexo_id']
//        ]);
//
////        $perfil->nombre = $request['nombre'];
////        $perfil->apellido = $request['apellido'];
////        $perfil->telefono = $request['telefono'];
////        $perfil->fechanacimiento = $request['fechanacimiento'];
////        $perfil->sexo_id = $request['sexo_id'];
////        $currentuser->perfil()->save($perfil);
//
//
//        $domicilio = new Domicilio([
//            'calle' => $request['calle'],
//            'nro' => $request['nro'],
//            'localidad_id' => $request['localidad_id'],
//            'lat' => 1,
//            'long' => 1
//        ]);
//
////        $domicilio->calle = $request['calle'];
////        $domicilio->nro = $request['numero'];
////        $domicilio->localidad_id = $request['localidad_id'];
////        $domicilio->lat = 1;
////        $domicilio->long = 1;
////        $domicilio->save();
//
//
//        $perfil->domicilio()->attach($domicilio);
//        $currentuser->perfil()->save($perfil);
    }

    /**
     * Display the specified resource.
     *
     * @param Perfil $perfil
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Perfil $perfil)
    {
        //        return view("perfil.edit",compact('perfil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $id = \Auth::user()->id;
        $currentuser = User::find($id);

        return view("perfil.edit")->with('perfil', $currentuser->perfil)->with('sexos', Sexo::all())->with('provincias', Provincia::all());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Perfil $perfil
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function update(Request $request)
    {
        //
        dd($request->all());
        $id = \Auth::user()->id;
        $currentuser = User::find($id);
        $currentuser->perfil->update($request->all());

        return back();
    }

    private function createUpdate(Request $request, bool $update)
    {
        DB::beginTransaction(); //Start transaction!

        try {
            $id = \Auth::user()->id;
            $currentuser = User::find($id);
            if ($update) {
                $currentuser->perfil->update($request->all());
                $currentuser->perfil->domicilio()->orderBy('timestamp', 'desc')->first()->update($request->all());
                create($request->all());
            } else {
                $currentuser->perfil->create($request->all());
                Domicilio::create($request->all());
            }





        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }

        DB::commit();
    }
}
