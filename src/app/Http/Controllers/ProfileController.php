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
        return redirect('profile');
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
        $this->createUpdate($request,true);
        return back();
    }

    private function createUpdate(Request $request,bool $update)
    {

        DB::beginTransaction(); //Start transaction!

        try {
            $id = \Auth::user()->id;
            $currentuser = User::find($id);


            if ($update) {
                $currentuser->perfil()->update([
                    'nombre' => $request['nombre'],
                    'apellido' => $request['apellido'],
                    'telefono' => $request['telefono'],
                    'fechanacimiento' => $request['fechanacimiento'],
                    'sexo_id' => $request['sexo_id']
                ]);
                $currentuser->perfil()->domicilio()->orderBy('timestamp', 'desc')->first()->update([
                    'calle' => $request['calle'],
                    'nro' => $request['nro'],
                    'localidad_id' => $request['localidad_id'],
                    'lat' => 1,
                    'long' => 1
                ]);

            } else {


                $perfil = $currentuser->perfil()->create([
                    'nombre' => $request['nombre'],
                    'apellido' => $request['apellido'],
                    'telefono' => $request['telefono'],
                    'fechanacimiento' => $request['fechanacimiento'],
                    'sexo_id' => $request['sexo_id']
                ]);


                $domicilio = new Domicilio([
                    'calle' => $request['calle'],
                    'nro' => $request['nro'],
                    'localidad_id' => $request['localidad_id'],
                    'lat' => 1,
                    'long' => 1
                ]);

                $domicilio->save();

                $perfil ->domicilio()->attach($domicilio);
            }


        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }

        DB::commit();
    }
}
