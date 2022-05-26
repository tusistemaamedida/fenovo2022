<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Localidad\LocalidadRequest;
use App\Models\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function getLocalidades(Request $request)
    {
        return Localidad::orderByDesc('id')->get();
    }

    public function createLocalidad()
    {
        return view('admin.localidades.create');
    }

    public function storeLocalidad(LocalidadRequest $request)
    {
        Localidad::create($request->all());
    }

    public function updateLocalidad($id)
    {
        $localidad = Localidad::findOrFail($id);
        return $localidad;
    }

    public function destroyLocalidad($id)
    {
        $localidad = Localidad::findOrFail($id);
        $localidad->delete();
    }
}
