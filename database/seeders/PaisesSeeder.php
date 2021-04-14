<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paises')->insert([
            [
                'pais_id' => 1,
                'nombre' => 'Argentina',
                'alpha3' => 'ARG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pais_id' => 2,
                'nombre' => 'Estados Unidos',
                'alpha3' => 'USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pais_id' => 3,
                'nombre' => 'Inglaterra',
                'alpha3' => 'ENG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
