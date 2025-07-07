<?php

namespace Database\Seeders;

use App\Models\FormaPagamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormaPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Transferência',
            'Transferência Express',
            'Deposito',
            'Cartão Multicaixa',
            'Dinheiro',
        ];

        foreach ($datas as $data) {
            $forma = FormaPagamento::all()->where('forma', $data)->first();
            if (!$forma) {
                FormaPagamento::create(['forma' => $data]);
            }
        }
    }
}
