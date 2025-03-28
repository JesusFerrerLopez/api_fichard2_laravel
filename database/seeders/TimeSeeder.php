<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leer el archivo JSON
        $jsonPath = database_path('seeders/times.json');
        $data = json_decode(File::get($jsonPath), true);

        // Insertar los datos en la tabla 'times'
        DB::table('times')->insert($data);

        echo "Seeder ejecutado: Datos insertados correctamente.\n";
    }
}
