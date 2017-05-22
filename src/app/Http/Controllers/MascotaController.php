<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Mascota;
use App\Models\Media;
use App\Models\Sexo;
use App\Models\Tamanio;
use App\Models\Tipo;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use stdClass;
use Storage;

class MascotaController extends BaseController
{
    public function index()
    {
        $mascotas = Auth::user()->perfil->mascota()->paginate(15);
        $listMascotaViewModel = array();
        foreach ($mascotas as $mascota) {
            $listMascotaViewModel[] = $this->MapToViewModel($mascota);
        }

        return view("mascota.index")->with("mascotas", $listMascotaViewModel);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("mascota.create")
            ->with('sexos', Sexo::all())
            ->with('tamanios', Tamanio::all())
            ->with('tipos', Tipo::all());

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
        $this->createUpdate($request, -1);

        return redirect(route('feed'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $userId = Auth::user()->id;
        $currentuser = User::find($userId);
        $mascota = $currentuser->perfil->mascota()->find($id);
        $followers = $mascota->seguido()->count();

        $posts = $mascota->post()->orderBy("created_at", "desc")->get();
        $feeds = array();
        foreach ($posts as $post) {

            $feeds[] = $this->PostToFeed($post, $mascota);
        }


        return view("mascota.show")
            ->with('mascota', $this->MapToViewModel($mascota))
            ->with('followers', $followers)
            ->with("feeds", $feeds)
            ->with('posts', $posts->count());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $userId = Auth::user()->id;
        $currentuser = User::find($userId);
        $mascota = $currentuser->perfil->mascota()->find($id);


        return view("mascota.edit")
            ->with('mascota', $this->MapToViewModel($mascota))
            ->with('sexos', Sexo::all())
            ->with('tamanios', Tamanio::all())
            ->with('tipos', Tipo::all());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->createUpdate($request, $id);

        return redirect(route('feed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function post(Request $request, $id)
    {

        $userId = Auth::user()->id;
        $currentuser = User::find($userId);
        $mascota = $currentuser->perfil->mascota()->find($id);

        DB::beginTransaction();
        try {
            $post = $mascota->post()->create(['content' => $request["content"]]);

            if ($request['media'] == 'image') {

                $path = $request->photo->store('posts');
                if ($request->hasFile('photo') && $request->photo->isValid()) {
                    $media = $post->media()->create([
                        'url' => $path,
                        'local' => true,
                        'extension' => $request->photo->extension()
                    ]);
                    $post->update(["media_id" => $media->id]);
                }
            } else if ($request['media'] == 'video') {
                $media = $post->media()->create([
                    'url' => $request["videoUrl"],
                    'local' => false,
                    'extension' => "video"
                ]);

                $post->update(["media_id" => $media->id]);
            }
            DB::commit();

            return redirect(route('mascota.show', ['id' => $mascota->id]));
        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }


    }


    private
    function MapToViewModel(Mascota $mascota)
    {
        $mascotaViewModel = new stdClass();
        $mascotaViewModel->id = $mascota->id;
        $mascotaViewModel->nombre = $mascota->nombre;
        $mascotaViewModel->dia_nacimiento = $mascota->dia;
        $mascotaViewModel->mes_nacimiento = $mascota->mes;
        $mascotaViewModel->anio_nacimiento = $mascota->anio;
        $mascotaViewModel->sexo_id = $mascota->sexo->id;
        $mascotaViewModel->tamanio_id = $mascota->tamanio->id;
        $mascotaViewModel->raza_id = $mascota->raza->id;
        $mascotaViewModel->tipo_id = $mascota->raza->tipo->id;
        $mascotaViewModel->adopcion = $mascota->adopcion;
        $mascotaViewModel->pareja = $mascota->cita;
        $mascotaViewModel->perdido = $mascota->perdido;

        /* parametricos detalle*/
        $mascotaViewModel->sexo = $mascota->sexo->descripcion;
        $mascotaViewModel->tipo = $mascota->raza->tipo->descripcion;
        $mascotaViewModel->raza = $mascota->raza->descripcion;
        $mascotaViewModel->tamanio = $mascota->tamanio->descripcion;
        $mascotaViewModel->en_adopcion = $mascota->adopcion ? "SI" : "NO";
        $mascotaViewModel->en_pareja = $mascota->cita ? "SI" : "NO";
        $mascotaViewModel->esta_perdido = $mascota->perdido ? "SI" : "NO";

        $imagen = $mascota->imagen()->latest()->first();


        $file = null;
        $extension = null;

        if (!empty($imagen) && Storage::disk('local')->exists($imagen->url)) {
            $file = Storage::get($imagen->url);
            $extension = $imagen->extension;
        }
        $mascotaViewModel->imagen = !empty($imagen) && !empty($file) && !empty($extension) ? 'data:image/' . $extension . ';base64,' . base64_encode($file) : null;

        if (empty($mascota->dia) && empty($mascota->mes)) {
            $mascotaViewModel->nacimiento = $mascota->anio;
        } elseif (empty($mascota->dia)) {
            $mascotaViewModel->nacimiento = $mascota->mes . "/" . $mascota->anio;
        } else {
            $mascotaViewModel->nacimiento = $mascota->dia . "/" . $mascota->mes . "/" . $mascota->anio;
        }

        return $mascotaViewModel;

    }

    private
    function createUpdate(Request $request, $id)
    {

        DB::beginTransaction(); //Start transaction!

        $userId = Auth::user()->id;
        $currentuser = User::find($userId);
        $mascota = $currentuser->perfil->mascota()->find($id);

        try {


            if (!is_null($mascota)) {
                $mascota->update([
                    'nombre' => $request['nombre'],
                    'dia' => $request['dia_nacimiento'],
                    'mes' => $request['mes_nacimiento'],
                    'anio' => $request['anio_nacimiento'],
                    'sexo_id' => $request['sexo_id'],
                    'raza_id' => $request['raza_id'],
                    'tamanio_id' => $request['tamanio_id']
                ]);

            } else {

                $nuevaMascota = $currentuser->perfil->mascota()->create([
                    'nombre' => $request['nombre'],
                    'dia' => $request['dia_nacimiento'],
                    'mes' => $request['mes_nacimiento'],
                    'anio' => $request['anio_nacimiento'],
                    'sexo_id' => $request['sexo_id'],
                    'raza_id' => $request['raza_id'],
                    'tamanio_id' => $request['tamanio_id']
                ]);
            }

        } catch (\Exception $e) {
            //failed logic here
            DB::rollback();
            throw $e;
        }

        $path = $request->photo->store('profiles');

        if ($request->hasFile('photo') && $request->photo->isValid()) {
            $imagen = new Imagen([
                'url' => $path,
                'extension' => $request->photo->extension()
            ]);

            $imagen->save();

            if (!is_null($mascota)) {
                $mascota->imagen()->sync($imagen);
            } else {
                $nuevaMascota->imagen()->sync($imagen);

            }

        }
        DB::commit();

    }
}
