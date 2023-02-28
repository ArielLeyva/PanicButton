<?php

namespace App\Models;

class Client extends BaseModel
{

    public function getAvatarPathAttribute()
    {
        if ($this->avatar !== null) {
            return asset("src/$this->avatar");
        } else {
            return "";
        }
    }

    /**
     * Obtener la dirección del cliente
     * 
     * @return Address El modelo de la dirección del producto
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Obtener la dirección del cliente
     * 
     * @return Button El modelo de la dirección del producto
     */
    public function button()
    {
        return $this->belongsTo(Button::class);
    }

    /**
     * Obtener la categoría del producto
     * 
     * @return TelephoneNumber Recupera todos los números de teléfonos del cliente
     */
    public function telephone_numbers()
    {
        return $this->hasMany(TelephoneNumber::class);
    }

    /**
     * Incluir la dirección y el botón del cliente en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->address) {
            $data['address'] = $this->address;
        } else {
            $data['address'] = null;
        }
        if ($this->button) {
            $data['button'] = $this->button->number;
        } else {
            $data['button'] = null;
        }
        if ($this->telephone_numbers) {
            $data['telephone_numbers'] = $this->telephone_numbers;
        } else {
            $data['telephone_numbers'] = [];
        }
        $data['avatar'] = $this->avatarPath;
        return $data;
    }
}
