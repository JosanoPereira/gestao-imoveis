<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipologiaSeeder::class,
            PropertyTypeSeeder::class,
            GeneroSeeder::class,
            ProvinciaMunicipioSeeder::class,
            TipoSeeder::class,
            RegimeSeeder::class,
            FormaPagamentoSeeder::class,
        ]);
    }
}
