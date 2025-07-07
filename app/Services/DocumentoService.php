<?php

namespace App\Services;

use App\Models\Documento;

class DocumentoService
{
    public function syncDocumentos(array $documentosData, array $vinculos = []): void
    {
        // Detectar tipo de vínculo (cliente, imóvel, ou proprietário)
        $clienteId = $vinculos['clientes_id'] ?? null;
        $imovelId = $vinculos['imoveis_id'] ?? null;
        $proprietarioId = $vinculos['proprietarios_id'] ?? null;

        // Coletar IDs existentes recebidos do frontend
        $idsRecebidos = array_filter(array_column($documentosData, 'id'));

        // Buscar documentos existentes com base no vínculo fornecido
        $query = Documento::query();
        if ($clienteId) $query->where('clientes_id', $clienteId);
        if ($imovelId) $query->where('imoveis_id', $imovelId);
        if ($proprietarioId) $query->where('proprietarios_id', $proprietarioId);

        $documentosExistentes = $query->get();

        // Remover documentos que não estão mais presentes
        $documentosExistentes->each(function ($documento) use ($idsRecebidos) {
            if (!in_array($documento->id, $idsRecebidos)) {
                if ($documento->path && file_exists(storage_path('app/public/' . $documento->path))) {
                    unlink(storage_path('app/public/' . $documento->path));
                }
                $documento->delete();
            }
        });

        // Atualizar ou criar os documentos
        foreach ($documentosData as $dado) {
            $documento = Documento::updateOrCreate(
                [
                    'id' => $dado['id'] ?? null,
                    'clientes_id' => $clienteId,
                    'imoveis_id' => $imovelId,
                    'proprietarios_id' => $proprietarioId,
                ],
                [
                    'tipo_documentos_id' => $dado['tipo_documentos_id'],
                    'numero' => $dado['numero'],
                    'emissao' => $dado['emissao'] ?? null,
                    'validade' => $dado['validade'] ?? null,
                    'vitalicio' => empty($dado['validade']),
                ]
            );

            // Upload de novo arquivo, se houver
            if (isset($dado['path']) && is_file($dado['path'])) {
                $prefixo = $clienteId ? "cliente-$clienteId" : ($imovelId ? "imovel-$imovelId" : "proprietario-$proprietarioId");
                $path = upload_as('documentos', $dado['path'], "documento-{$prefixo}-{$documento->id}");
                $documento->update(['path' => $path]);
            }
        }
    }
}
