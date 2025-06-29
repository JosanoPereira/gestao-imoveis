<?php

namespace App\Services;

use App\Models\Imovel;
use App\Models\Municipio;
use App\Models\PropertyType;
use App\Models\Proprietario;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use App\Models\Tipologia;
use Illuminate\Support\Facades\DB;

class ImovelService
{
    public function dataService(?Imovel $imovel = null): array
    {
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();
        $tipologias = Tipologia::all();
        $tipoImoveis = PropertyType::all();
        $proprietarios = Proprietario::with('pessoa')->get();

        dd($proprietarios->first());

        return [
            'municipios' => $municipios,
            'provincias' => $provincias,
            'tipoDocumentos' => $tipoDocumentos,
            'tipologias' => $tipologias,
            'tipoImoveis' => $tipoImoveis,
            'proprietarios' => $proprietarios
        ];
    }

    public function getImoveis()
    {
        return DB::table('imoveis')
            ->join('tipologias', 'tipologias.id', 'imoveis.tipologias_id')
            ->join('property_types', 'property_types.id', 'imoveis.property_types_id')
            ->join('enderecos', 'enderecos.id', 'imoveis.enderecos_id')
            ->whereNull('imoveis.deleted_at')
            ->select([
                '*',
                'imoveis.id as id',
            ])
            ->get()
            ->map(function ($dado) {
            });
    }
}
