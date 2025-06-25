<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentos = [
            'Bilhete de Identidade',
            'Certidao Comercial',
            'Passaporte',
            'Alvara',
            'Comprovativo de Identificacao Fiscal',
        ];

        $clientes = [
            'Pessoa Singular',
            'Empresas',
        ];

        foreach ($documentos as $dado => $key) {
            $documento = DB::table('tipo_documentos')->where('tipo', $key)->first();
            if (!$documento) {
                DB::table('tipo_documentos')->insert([
                    'tipo' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($clientes as $dado => $key) {
            $cliente = DB::table('tipo_clientes')->where('tipo', $key)->first();
            if (!$cliente) {
                DB::table('tipo_clientes')->insert([
                    'tipo' => $key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
