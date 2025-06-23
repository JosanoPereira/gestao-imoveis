<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            'Comercial',
            'Habitacional',
            'Industrial',
            'Escritório',
            'Terreno',
            'Rural',
            'Loteamento',
            'Condomínio',
            'Pousada',
            'Hotel',
            'Flat',
            'Loja',
            'Galpão',
            'Armazém',
            'Salão Comercial',
            'Sala Comercial',
            'Casa Comercial',
            'Prédio Comercial',
            'Barracão Industrial'
        ];

        foreach ($datas as $data) {
            $propertyType = PropertyType::all()->where('name', $data)->first();
            if (!$propertyType) {
                PropertyType::create(['name' => $data]);
            }
        }
    }
}
