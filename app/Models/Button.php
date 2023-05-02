<?php

namespace App\Models;

class Button extends BaseModel
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
            $data['client'] = [
                'avatar' => asset("src/blank-profile.svg"),
                'name' => 'Sin asignar',
                'email' => '',
                'address_id' => null,
                'telephone_numbers' => [],
                'state' => 'Activo',
            ];
        }
        return $data;
    }
}
