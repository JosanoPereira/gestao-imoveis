<?php

namespace App\Services;

use App\Models\Endereco;
use App\Models\Imovel;
use App\Models\ImovelImagem;
use App\Models\Municipio;
use App\Models\PropertyType;
use App\Models\Proprietario;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use App\Models\Tipologia;
use Illuminate\Support\Facades\DB;

class ImovelService
{
    private DocumentoService $documentoService;

    public function __construct()
    {
        $this->documentoService = new DocumentoService();
    }

    public function dataService(?Imovel $imovel = null): array
    {
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();
        $tipologias = Tipologia::all();
        $tipoImoveis = PropertyType::all();
        $proprietarios = Proprietario::with('pessoa')->get();

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
            ->join('enderecos', 'enderecos.imoveis_id', 'imoveis.id')

            ->whereNull('imoveis.deleted_at')
            ->select([
                '*',
                'imoveis.id as id',
            ])
            ->get();
    }

    public function createProperty(array $data): Imovel
    {
        $imovel = Imovel::create([
            'area_util' => $data['area_util'],
            'numero_compartimentos' => $data['numero_compartimentos'],
            'estado_conservacao' => $data['estado_conservacao'],
            'tipologias_id' => $data['tipologias_id'],
            'property_types_id' => $data['property_types_id'],
            'proprietarios_id' => $data['proprietarios_id'],
        ]);

        $endereco = Endereco::create([
            'imoveis_id' => $imovel->id,
            'municipios_id' => $data['municipios_id'],
            'endereco' => $data['endereco'],
            'bairro' => $data['bairro'],
        ]);

        // Documentos
        if (!empty($data['documentos'])) {
            $this->documentoService->syncDocumentos($data['documentos'], ['imoveis_id' => $imovel->id]);
        }

        //Imagens
        if (!empty($data['imagens'])) {
            foreach ($data['imagens'] as $imagem) {
                if (isset($imagem) && is_file($imagem)) {
                    $path = upload_as('imoveis/imagens', $imagem, "imovel-imagem-{$imovel->id}-{$imagem->getClientOriginalName()}");
                    ImovelImagem::create([
                        'imoveis_id' => $imovel->id,
                        'image' => $path,
                    ]);
                }
            }
        }
        return $imovel;
    }
}
