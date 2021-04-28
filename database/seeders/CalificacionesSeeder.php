<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('calificaciones')->insert([
            [
                'calificacion_id' => 1,
                'nombre' => 'Apto Todo Público',
                'abreviatura' => 'ATP',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'calificacion_id' => 2,
                'nombre' => 'Mayores de 13',
                'abreviatura' => '13+',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'calificacion_id' => 3,
                'nombre' => 'Mayores de 16',
                'abreviatura' => '16+',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'calificacion_id' => 4,
                'nombre' => 'Mayores de 18',
                'abreviatura' => '18+',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
