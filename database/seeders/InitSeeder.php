<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Horario;

class InitSeeder extends Seeder {
  public function run(): void {
    User::updateOrCreate(['email'=>'admin@appsalon.test'],[
      'name'=>'Admin','apellido'=>'AppSalon','password'=>bcrypt('admin123'),
      'admin'=>true,'confirmado'=>true
    ]);
    User::updateOrCreate(['email'=>'cliente@appsalon.test'],[
      'name'=>'Cliente','apellido'=>'Demo','password'=>bcrypt('cliente123'),
      'admin'=>false,'confirmado'=>true
    ]);

    Servicio::insert([
      ['nombre'=>'Corte Dama','precio'=>35000,'created_at'=>now(),'updated_at'=>now()],
      ['nombre'=>'Corte Caballero','precio'=>25000,'created_at'=>now(),'updated_at'=>now()],
      ['nombre'=>'Manicure','precio'=>20000,'created_at'=>now(),'updated_at'=>now()],
      ['nombre'=>'Pedicure','precio'=>25000,'created_at'=>now(),'updated_at'=>now()],
      ['nombre'=>'Tintura','precio'=>80000,'created_at'=>now(),'updated_at'=>now()],
    ]);

    foreach (range(1,6) as $d){ // Lun-Sáb 9-18
      Horario::create(['dia_semana'=>$d,'abre'=>'09:00','cierra'=>'18:00','duracion_min'=>30]);
    }
  }
}