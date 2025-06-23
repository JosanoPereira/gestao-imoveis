<?php

namespace Database\Seeders;

use App\Models\Tipologia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dados = [
            'T10',
            'T4',
            'T3',
            'T2',
            'T1',
            'T0',
            'T5',
            'T6',
            'T4+1',
            'T3+1',
            'T2+1',
        ];

        foreach ($dados as $dado){
            $tipologia = Tipologia::all()->where('tipo', $dado)->first();
            if (!$tipologia) {
                Tipologia::create([
                    'tipo' => $dado,
                    'descricao' => null,
                    'ativo' => true,
                ]);
            }
        }
    }
}
