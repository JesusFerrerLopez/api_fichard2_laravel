<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Leer el archivo JSON
        $jsonPath = database_path('seeders/users.json');
        $data = json_decode(File::get($jsonPath), true);

        // Insertar los datos en la tabla 'times'
        DB::table('users')->insert($data);

        echo "Seeder ejecutado: Datos insertados correctamente.\n";
    }
}
