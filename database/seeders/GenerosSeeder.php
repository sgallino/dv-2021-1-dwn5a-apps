<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generos')->insert([
            [
                'genero_id' => 1,
                'nombre' => 'Drama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 2,
                'nombre' => 'Fantasía',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 3,
                'nombre' => 'Ciencia Ficción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 4,
                'nombre' => 'Romance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'genero_id' => 5,
                'nombre' => 'Histórica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
