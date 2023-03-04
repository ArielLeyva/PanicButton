<?php

namespace App\Models;

class Alert extends BaseModel
{
    /**
     * Obtener la dirección del cliente
     * 
     * @return Client El modelo de la dirección del producto
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Incluir la dirección y el botón del cliente en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = null;
        }
        return $data;
    }
}
