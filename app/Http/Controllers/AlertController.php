<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();
        $sort = $alerts->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function readed($id)
    {
        Alert::find($id)->update(['state' => 'Vista']);
        return response('');
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Alert::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar la alerta', 422);
        }
    }
}
