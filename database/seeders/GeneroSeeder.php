<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generos = [
            'Masculino',
            'Feminino',
            'Outro',
        ];

        $estados = [
            'Casado (a)',
            'Divorciado (a)',
            'Solteiro (a)',
            'Viuvo (a)',
        ];

        foreach ($generos as $genero => $key) {
            $genero = DB::table('generos')->where('genero', $key)->first();
            if (!$genero) {
                DB::table('generos')->insert([
                    'genero' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($estados as $estado => $key) {
            $estado = DB::table('estado_civil')->where('estado', $key)->first();
            if (!$estado) {
                DB::table('estado_civil')->insert([
                    'estado' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
