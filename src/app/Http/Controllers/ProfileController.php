<?php

namespace App\Http\Controllers;

use App\Models\Domicilio;
use App\Models\Imagen;
use App\Models\Mascota;
use App\Models\PerfilLikePost;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Provincia;
use App\Models\Perfil;
use App\Models\Sexo;
use App\User;
use DB;
use stdClass;
use Storage;
use Auth;

class ProfileController extends BaseController
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


        return redirect()->route('feed');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
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
        $this->createUpdate($request);
        return redirect(route('feed'));
    }

    /**
     * Display the specified resource.
     *
     * @param Perfil $perfil
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($id)
    {
        //        return view("perfil.edit",compact('perfil'));

        $perfil = Perfil::find($id);
        $imagen = $perfil->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }



        $profile = new stdClass();
        $profile->image = !empty($extension) && !empty($file) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;
        $profile->nombre = $perfil->nombre;
        $profile->apellido = $perfil->apellido;
        $profile->following = $perfil->sigue()->count();


        $misMascotas = $perfil->mascota()->get();
        $followers = 0;
        $mascotasViewModel = array();
        foreach ($misMascotas as $mascota){
            $followers += $mascota->seguido()->count();
            $mascotasViewModel[] = $this->MapToMascotaViewModel($mascota);
        }
        $profile->followers = $followers;


        return view("perfil.show")->with("profile", $profile)->with("mascotas",$mascotasViewModel);
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


        $id = Auth::user()->id;
        $currentuser = User::find($id);

        $imagen = $currentuser->perfil->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }


        return view("perfil.edit")
            ->with('perfil', $currentuser->perfil)
            ->with('sexos', Sexo::all())
            ->with('provincias', Provincia::all())
            ->with('domicilio', $currentuser->perfil->domicilio->first())
            ->with('imagen', !empty($extension) && !empty($file) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null)
            ->with('departamento_id', $currentuser->perfil->domicilio->first()->localidad->departamento_id)
            ->with('provincia_id', $currentuser->perfil->domicilio->first()->localidad->departamento->provincia_id);

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
        $this->createUpdate($request);

        return redirect(route('feed'));
    }

    public function comment(Request $request)
    {
        $mascota = Auth::user()->perfil->sigue()->find($request["mascota_id"]);
        if (!is_null($mascota)) {
            $mascota->post()->find($request["post_id"])->perfil_like_post()->create([
                "coment" => is_null($request["coment"]) ? "" : $request["coment"],
                "like" => $request["like"] ? 1 : 0,
                "perfil_id" => Auth::user()->perfil->id
            ]);

            return redirect()->back();
        }

        return redirect(route('feed'));

    }

    public function follow(Request $request)
    {
        $perfil = Auth::user()->perfil;
        if (!$perfil->sigue()->find($request["mascota_id"]) && is_null($perfil->mascota()->find($request["mascotaId"]))) {

            $mascotaToFollow = Mascota::find($request["mascota_id"]);

            if (!is_null($mascotaToFollow)) {

                $perfil->sigue()->attach($mascotaToFollow);

                return redirect(route('mascota.show', ["id" => $mascotaToFollow->id]));
            }
        }

        return redirect(route('feed'));
    }

    public function unfollow(Request $request)
    {
        $perfil = Auth::user()->perfil;
        if ($perfil->sigue()->find($request["mascota_id"]) && is_null($perfil->mascota()->find($request["mascotaId"]))) {

            $mascotaToUnFollow = Mascota::find($request["mascota_id"]);

            if (!is_null($mascotaToUnFollow)) {

                $perfil->sigue()->detach($mascotaToUnFollow);

                return redirect(route('mascota.show', ["id" => $mascotaToUnFollow->id]));
            }
        }

        return redirect(route('feed'));
    }

    private function createUpdate(Request $request)
    {

        DB::beginTransaction(); //Start transaction!

        $id = Auth::user()->id;
        $currentuser = User::find($id);

        try {


            if (!is_null($currentuser->perfil)) {
                $currentuser->perfil()->update([
                    'nombre' => $request['nombre'],
                    'apellido' => $request['apellido'],
                    'telefono' => $request['telefono'],
                    'fechanacimiento' => $request['fechanacimiento'],
                    'sexo_id' => $request['sexo_id']
                ]);

                $currentuser->perfil->domicilio->first()->update([
                    'calle' => $request['calle'],
                    'numero' => $request['numero'],
                    'localidad_id' => $request['localidad_id'],
                    'lat' => $request['lat'],
                    'long' => $request['long']
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
                    'numero' => $request['numero'],
                    'localidad_id' => $request['localidad_id'],
                    'lat' => $request['lat'],
                    'long' => $request['long'],
                    'perfil_id' => $perfil->id
                ]);

                $domicilio->save();


            }


        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }



        if ($request->hasFile('photo') && $request->photo->isValid()) {

            $path = $request->photo->store('profiles');
            $imagen = new Imagen([
                'url' => $path,
                'extension' => $request->photo->extension()
            ]);

            $imagen->save();

            if (empty($currentuser->perfil)) {
                DB::commit();
            }
            if (!is_null($currentuser->perfil)) {
                $currentuser->perfil->imagen()->sync($imagen);
            } else {
                $perfil->imagen()->sync($imagen);
            }


        }
        DB::commit();

    }
}
