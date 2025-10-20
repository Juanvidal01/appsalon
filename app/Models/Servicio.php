<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
   protected $fillable = ['nombre','precio'];
  public function citas(){ return $this->belongsToMany(Cita::class, 'cita_servicio'); }
}
