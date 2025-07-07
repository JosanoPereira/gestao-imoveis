<?php

namespace Database\Seeders;

use App\Models\Regime;
use Illuminate\Database\Seeder;

class RegimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Mensal',
            'Anual',
            'Semestral',
            'Trimestral',
            'Bimestral',
            'Quinzenal',
            'Semanal',
            'Diário',
            'Horário',
            'Pontual',
        ];

        foreach ($datas as $data) {
            $regime = Regime::all()->where('regime', $data)->first();
            if (!$regime) {
                Regime::create(['regime' => $data]);
            }
        }
    }
}
