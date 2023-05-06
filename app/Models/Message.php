<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
{

    public function getImagePathAttribute()
    {
        if ($this->image !== null) {
            return asset("src/$this->image");
        } else {
            return null;
        }
    }

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
        $data['image'] = $this->imagePath;
        return $data;
    }
}
