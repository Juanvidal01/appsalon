<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = ['fecha', 'hora', 'hora_fin', 'user_id', 'estado'];

    // Ajuste de casts para columnas TIME (HH:MM:SS) y DATE
    protected $casts = [
        'fecha'    => 'date',
        'hora'     => 'datetime:H:i:s',
        'hora_fin' => 'datetime:H:i:s',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio');
    }

    public function getTotalAttribute()
    {
        return $this->servicios->sum('precio');
    }
}
