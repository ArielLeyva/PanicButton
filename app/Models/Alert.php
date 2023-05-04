<?php

namespace App\Models;

class Alert extends BaseModel
{

    /**
     * Scope para incluir todos los registros con los ids pasados en el argumento $ids
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $ids Ids de los modelos a incluir en el scope
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeButtons($query, $ids)
    {
        foreach ($ids as $id) {
            $query = $query->orWhere('button_id', $id);
        }
        return $query;
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
