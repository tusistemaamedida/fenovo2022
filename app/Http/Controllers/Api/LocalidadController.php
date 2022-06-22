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
        return Localidad::buscarNombre($request->name)->orderBy('nombre')->paginate(10);
    }

    public function storeLocalidad(LocalidadRequest $request)
    {
        Localidad::create($request->all());
    }

    public function updateLocalidad(LocalidadRequest $request, $id)
    {
        Localidad::find($id)->update($request->all());
    }

    public function destroyLocalidad($id)
    {
        Localidad::find($id)->delete();
    }
}
