<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Localidad;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function getLocalidades(Request $request)
    {
        return Localidad::orderByDesc('id')->get();
    }

    public function storeLocalidad(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);

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
