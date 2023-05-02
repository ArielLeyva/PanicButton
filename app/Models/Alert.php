<?php

namespace App\Models;

class Alert extends BaseModel
{
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
     * Incluir la dirección y el botón del cliente en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->button) {
            $data['button'] = $this->button;
        } else {
            $data['button'] = null;
        }
        return $data;
    }
}
