<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class ClienteService
{
    private $documentoService;
    public function __construct()
    {
        $this->documentoService = new DocumentoService();
    }

    /**
     * Sincroniza os contactos do cliente.
     */
    private function syncContactos(array $contactosData, int $clienteId)
    {
        // IDs recebidos do front para controle
        $idsRecebidos = array_filter(array_column($contactosData, 'id'));

        // Buscar contactos existentes do cliente
        $contactosExistentes = Contacto::where('clientes_id', $clienteId)->get();

        // Excluir contactos que não estão no array enviado (removidos no front)
        $contactosExistentes->each(function ($contacto) use ($idsRecebidos) {
            if (!in_array($contacto->id, $idsRecebidos)) {
                $contacto->delete();
            }
        });

        // Criar ou atualizar cada contacto enviado
        foreach ($contactosData as $dado) {
            Contacto::updateOrCreate(
                ['id' => $dado['id'] ?? null, 'clientes_id' => $clienteId],
                [
                    'telefone' => $dado['telefone'] ?? null,
                    'email' => $dado['email'] ?? null,
                ]
            );
        }
    }


    // Pessoa Singular
    private function criarOuAtualizarPessoaSingular(array $data, ?int $id = null): Pessoa
    {
        return $id
            ? tap(Pessoa::findOrFail($id))->update([
                'nome' => $data['nome'],
                'data_nascimento' => $data['data_nascimento'],
                'generos_id' => $data['generos_id'],
                'estado_civil_id' => $data['estado_civil_id'],
                'nacionalidade' => $data['nacionalidade'],
            ])
            : Pessoa::create([
                'nome' => $data['nome'],
                'data_nascimento' => $data['data_nascimento'],
                'generos_id' => $data['generos_id'],
                'estado_civil_id' => $data['estado_civil_id'],
                'nacionalidade' => $data['nacionalidade'],
            ]);
    }

    // Pessoa Coletiva
    private function criarOuAtualizarEmpresa(array $data, ?int $id = null): Empresa
    {
        return $id
            ? tap(Empresa::findOrFail($id))->update([
                'nome_social' => $data['nome_social'],
                'nome_fantasia' => $data['nome_fantasia'],
                'tipo_empresa' => $data['tipo_empresa'],
                'responsavel' => $data['responsavel'],
                'data_registo' => $data['data_registo'],
            ])
            : Empresa::create([
                'nome_social' => $data['nome_social'],
                'nome_fantasia' => $data['nome_fantasia'],
                'tipo_empresa' => $data['tipo_empresa'],
                'responsavel' => $data['responsavel'],
                'data_registo' => $data['data_registo'],
            ]);
    }

    public function createCliente(array $data): Cliente
    {
        DB::beginTransaction();

        try {
            // Verificar duplicação de NIF
            if (Cliente::where('nif', $data['nif'])->exists()) {
                throw new \Exception('NIF já existe na base de dados.');
            }

            $pessoaSingular = null;
            $pessoaColetiva = null;

            if ($data['tipo_clientes_id'] == 1) {
                $pessoaSingular = $this->criarOuAtualizarPessoaSingular($data);
            } else {
                $pessoaColetiva = $this->criarOuAtualizarEmpresa($data);
            }

            $cliente = Cliente::create([
                'pessoas_id' => $pessoaSingular?->id,
                'empresas_id' => $pessoaColetiva?->id,
                'tipo_clientes_id' => $data['tipo_clientes_id'],
                'nif' => $data['nif'],
            ]);

            Endereco::create([
                'clientes_id' => $cliente->id,
                'municipios_id' => $data['municipios_id'],
                'endereco' => $data['endereco'],
                'bairro' => $data['bairro'],
            ]);

            // Contactos
            if (!empty($data['contactos'])) {
                $this->syncContactos($data['contactos'], $cliente->id);
            }

            // Documentos
            if (!empty($data['documentos'])) {
                $this->documentoService->syncDocumentos($data['documentos'], ['clientes_id' => $cliente->id]);
            }

            DB::commit();
            return $cliente;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // deixa o controller tratar
        }
    }

    public function updateCliente(array $data, Cliente $cliente): Cliente
    {
        DB::beginTransaction();

        try {
            $pessoaSingular = null;
            $pessoaColetiva = null;

            if ($data['tipo_clientes_id'] == 1) {
                $pessoaSingular = $this->criarOuAtualizarPessoaSingular($data, $cliente->pessoas_id);
            } else {
                $pessoaColetiva = $this->criarOuAtualizarEmpresa($data, $cliente->empresas_id);
            }

            $cliente->update([
                'pessoas_id' => $pessoaSingular?->id,
                'empresas_id' => $pessoaColetiva?->id,
                'tipo_clientes_id' => $data['tipo_clientes_id'],
                'nif' => $data['nif'],
            ]);

            // Atualizar endereço
            $endereco = Endereco::where('clientes_id', $cliente->id)->first();
            if ($endereco) {
                $endereco->update([
                    'municipios_id' => $data['municipios_id'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                ]);
            }

            // Sincronizar contactos
            if (!empty($data['contactos'])) {
                $this->syncContactos($data['contactos'], $cliente->id);
            }

            // Sincronizar documentos
            if (!empty($data['documentos'])) {
                $this->documentoService->syncDocumentos($data['documentos'], ['clientes_id' => $cliente->id]);
            }

            DB::commit();
            return $cliente;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteCliente(Cliente $cliente): void
    {
        DB::beginTransaction();
        try {
            $pessoaSingular = Pessoa::find($cliente->pessoas_id);
            if ($pessoaSingular) {
                $pessoaSingular->delete();
            }

            $pessoaColetiva = Empresa::find($cliente->empresas_id);
            if ($pessoaColetiva) {
                $pessoaColetiva->delete();
            }

            $contactos = Contacto::all()->where('clientes_id', $cliente->id);
            if ($contactos) {
                foreach ($contactos as $dado) {
                    $dado->delete();
                }
            }

            $documentos = Documento::all()->where('clientes_id', $cliente->id);
            if ($documentos) {
                foreach ($contactos as $dado) {
                    $dado->delete();
                }
            }

            $enderecos = Endereco::all()->where('clientes_id', $cliente->id);
            if ($enderecos) {
                foreach ($enderecos as $dado) {
                    $dado->delete();
                }
            }

            $cliente->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // deixa o controller tratar
        }
    }

    public function getClientes()
    {
        return DB::table('clientes')
            ->leftJoin('pessoas', 'pessoas.id', 'clientes.pessoas_id')
            ->leftJoin('empresas', 'empresas.id', 'clientes.empresas_id')
            ->join('tipo_clientes', 'tipo_clientes.id', 'clientes.tipo_clientes_id')
            ->join('enderecos', 'enderecos.clientes_id', 'clientes.id')
            ->join('municipios', 'enderecos.municipios_id', 'municipios.id')
            ->join('provincias', 'provincias.id', 'municipios.provincias_id')
            ->whereNull('clientes.deleted_at') // Soft delete
            ->select([
                '*',
                'clientes.id as id',
            ])
            ->get()
            ->map(function ($cliente) {
                $cliente->nome = $cliente->nome ?? $cliente->nome_social;
                return $cliente;
            });
    }
}
