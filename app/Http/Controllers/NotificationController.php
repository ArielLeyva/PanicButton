<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        $sort = $notifications->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Notification::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar la notificación', 422);
        }
    }
}
