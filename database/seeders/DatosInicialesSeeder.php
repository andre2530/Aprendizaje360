<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatosInicialesSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar grados
        DB::table('grados')->insert([
            ['nombre' => '1ro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '2do', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '3ro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '4to', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '5to', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => '6to', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insertar secciones
        DB::table('secciones')->insert([
            ['nombre' => 'A', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'B', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'C', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'D', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'E', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insertar director
        DB::table('usuarios')->insert([
            'name' => 'Director General',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Cambiar luego
            'rol' => 'director',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insertar un docente como ejemplo
        DB::table('usuarios')->insert([
            'name' => 'Maria vega Elizalde',
            'email' => 'marivega@gmail.com',
            'password' => Hash::make('12345678'), // Cambiar luego
            'rol' => 'docente',
            'grado_id' => 1,    // Asegúrate que este ID exista
            'seccion_id' => 1,  // Asegúrate que este ID exista
            'created_at' => now(),
            'updated_at' => now(),
        ]);
      
}
}