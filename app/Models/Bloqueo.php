<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model { protected $fillable=['fecha','hora_inicio','hora_fin','motivo']; }
