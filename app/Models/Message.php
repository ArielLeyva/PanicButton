<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
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
     * Obtener la dirección del cliente
     *
     * @return User El modelo de la dirección del producto
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para incluir todos los registros con los ids pasados en el argumento $ids
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $ids Ids de los modelos a incluir en el scope
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIds($query, $ids)
    {
        foreach ($ids as $id) {
            $query = $query->orWhere('id', $id);
        }
        return $query;
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
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        return $data;
    }
}
