<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'client';

    public function getAvatarPathAttribute()
    {
        if ($this->avatar !== null) {
            return asset("src/$this->avatar");
        } else {
            return asset("src/blank-profile.svg");
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
    public function buttons()
    {
        return $this->hasMany(Button::class);
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
        if ($this->buttons) {
            $data['buttons'] = [];
            foreach ($this->buttons as $button) {
                array_push($data['buttons'], $button->number);
            }
        } else {
            $data['buttons'] = [];
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
