<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Bloqueo;
use Illuminate\Support\Carbon;

class HorariosSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Lunes (1) a Sábado (6): 9:00–18:00, bloques de 30 min
        foreach (range(1,6) as $dia) {
            Horario::updateOrCreate(
                ['dia_semana' => $dia, 'abre' => '09:00', 'cierra' => '18:00'],
                ['duracion_min' => 30]
            );
        }
        // 2) Domingo (7): cerrado (no insertes nada para 7) — así no genera slots

    
        $desde = Carbon::today();
        $hasta = Carbon::today()->addDays(14);
        for ($f = $desde->copy(); $f->lte($hasta); $f->addDay()) {
         
            if ($f->isSunday()) continue;
            Bloqueo::firstOrCreate([
                'fecha'       => $f->toDateString(),
                'hora_inicio' => '13:00',
                'hora_fin'    => '14:00',
                'motivo'      => 'Almuerzo',
            ]);
        }

    
        Bloqueo::firstOrCreate([
            'fecha'       => '2025-11-01',
            'hora_inicio' => '00:00',
            'hora_fin'    => '23:59',
            'motivo'      => 'Feriado Todos los Santos',
        ]);

     
        Horario::where(['dia_semana'=>6, 'abre'=>'09:00', 'cierra'=>'18:00'])->delete();
        Horario::updateOrCreate(
            ['dia_semana'=>6, 'abre'=>'09:00','cierra'=>'13:00'],
            ['duracion_min'=>30]
        );

 
    }
}
