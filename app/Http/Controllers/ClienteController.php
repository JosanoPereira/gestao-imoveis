<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\EstadoCivil;
use App\Models\Genero;
use App\Models\Municipio;
use App\Models\Pessoa;
use App\Models\Provincia;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = DB::table('clientes')
            ->leftJoin('pessoas', 'pessoas.id', 'clientes.pessoas_id')
            ->leftJoin('empresas', 'empresas.id', 'clientes.empresas_id')
            ->join('tipo_clientes', 'tipo_clientes.id', 'clientes.tipo_clientes_id')
            ->join('enderecos', 'enderecos.clientes_id', 'clientes.id')
            ->join('municipios', 'enderecos.municipios_id', 'municipios.id')
            ->join('provincias', 'provincias.id', 'municipios.provincias_id')
            ->get([
                '*',
                'clientes.id as id',
            ]);

        $clientes->map(function ($cliente) {
            $cliente->nome = $cliente->nome ?? $cliente->nome_social;
        });

        return Inertia::render('Clientes/Index', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::all();
        $estados = EstadoCivil::all();
        $tipoClinetes = TipoCliente::all();
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();

        return Inertia::render('Clientes/Create', [
            'generos' => $generos,
            'estados' => $estados,
            'tipoClientes' => $tipoClinetes,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'tipoDocumentos' => $tipoDocumentos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request)
    {
        try {
            DB::beginTransaction();
            $pessoaSingular = null;
            $pessoaColetiva = null;

            $clienteNif = Cliente::all()->where('nif', $request->nif)->first();
            if ($clienteNif) {
                return redirect()->back()->with('erro', 'Nif ja existe na nossa base de dados');
            }
            if ($request->tipo_clientes_id == 1) {
                $pessoaSingular = Pessoa::create([
                    'nome' => $request->nome,
                    'data_nascimento' => $request->data_nascimento,
                    'generos_id' => $request->generos_id,
                    'estado_civil_id' => $request->estado_civil_id,
                    'nacionalidade' => $request->nacionalidade,
                ]);
            } else {
                $pessoaColetiva = Empresa::create([
                    'nome_social' => $request->nome_social,
                    'nome_fantasia' => $request->nome_fantasia,
                    'tipo_empresa' => $request->tipo_empresa,
                    'responsavel' => $request->responsavel,
                    'data_registo' => $request->data_registo,
                ]);
            }

            $cliente = Cliente::create([
                'pessoas_id' => $pessoaSingular?->id,
                'empresas_id' => $pessoaColetiva?->id,
                'tipo_clientes_id' => $request->tipo_clientes_id,
                'nif' => $request->nif,
            ]);

            $endereco = Endereco::create([
                'clientes_id' => $cliente->id,
                'municipios_id' => $request->municipios_id,
                'endereco' => $request->endereco,
                'bairro' => $request->bairro,
            ]);
            if (!empty($request->contactos)) {
                foreach ($request->contactos as $dado) {
                    if (verificar_contacto($dado['telefone'], $dado['email'])) {
                        continue;
                    } else {
                        Contacto::create([
                            'clientes_id' => $cliente->id,
                            'telefone' => $dado['telefone'],
                            'email' => $dado['email']
                        ]);
                    }
                }
            }

            if (!empty($request->documentos)) {
                foreach ($request->documentos as $dado) {
                    if (verificar_documento($dado['numero'], $dado['tipo_documentos_id'])) {
                        continue;
                    } else {
                        $documento = Documento::create([
                            'clientes_id' => $cliente->id,
                            'tipo_documentos_id' => $dado['tipo_documentos_id'],
                            'numero' => $dado['numero'],
                            'emissao' => $dado['emissao'],
                            'validade' => $dado['validade'],
                            'vitalicio' => !$dado['validade'],
                        ]);
                        if (isset($dado['path']) && is_file($dado['path'])) {
                            $path = upload_as('documentos/clientes', $dado['path'], 'documento-' . $cliente->id . '-' . $documento->id);
                            $documento->update([
                                'path' => $path
                            ]);
                        }
                    }
                }
            }
            DB::commit();
            Log::info('Cliente Gravado com sucesso');
            return redirect()->route('clientes.index')->with('sucesso', 'Cliente Gravado com sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Ocorreu um erro grave' . $exception->getMessage());
            return redirect()->back()->with('erro', 'Erro ao gravar o Cliente');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $generos = Genero::all();
        $estados = EstadoCivil::all();
        $tipoClinetes = TipoCliente::all();
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();

        $pessoaSingular = Pessoa::find($cliente->pessoas_id);
        $pessoaColectiva = Empresa::find($cliente->empresas_id);

        $documentos = Documento::all()->where('clientes_id', $cliente->id);
        $contactos = Contacto::all()->where('clientes_id', $cliente->id);

        $endereco = DB::table('enderecos')
            ->join('municipios', 'enderecos.municipios_id', 'municipios.id')
            ->join('provincias', 'provincias.id', 'municipios.provincias_id')
            ->where('clientes_id', $cliente->id)
            ->get([
                '*', 'enderecos.id as id'
            ])->first();

        $documentosArray = [];
        foreach ($documentos as $doc) {
            $documentosArray[] = [
                'numero' => $doc->numero,
                'emissao' => $doc->emissao,
                'validade' => $doc->validade,
                'tipo_documentos_id' => $doc->tipo_documentos_id,
                'path' => $doc->path,
                'download' => true,
                'download_link' => asset('storage/' . $doc->path),
            ];
        }

        $contactosArray = [];
        foreach ($contactos as $cont) {
            $contactosArray[] = [
                'telefone' => $cont->telefone,
                'email' => $cont->email,
                // Adicione mais campos se necessário
            ];
        }

        $cliente->documentos = $documentosArray;
        $cliente->contactos = $contactosArray;

        $cliente->provincias_id = $endereco->provincias_id;
        $cliente->municipios_id = $endereco->municipios_id;
        $cliente->endereco = $endereco->endereco;
        $cliente->bairro = $endereco->bairro;

        $cliente->nome = $pessoaSingular?->nome;
        $cliente->data_nascimento = $pessoaSingular?->data_nascimento;
        $cliente->generos_id = $pessoaSingular?->generos_id;
        $cliente->estado_civil_id = $pessoaSingular?->estado_civil_id;
        $cliente->nacionalidade = $pessoaSingular?->nacionalidade;

        $cliente->nome_social = $pessoaColectiva?->nome_social;
        $cliente->nome_fantasia = $pessoaColectiva?->nome_fantasia;
        $cliente->tipo_empresa = $pessoaColectiva?->tipo_empresa;
        $cliente->responsavel = $pessoaColectiva?->responsavel;
        $cliente->data_registo = $pessoaColectiva?->data_registo;


        return Inertia::render('Clientes/Show', [
            'generos' => $generos,
            'estados' => $estados,
            'tipoClientes' => $tipoClinetes,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'tipoDocumentos' => $tipoDocumentos,
            'cliente' => $cliente
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $generos = Genero::all();
        $estados = EstadoCivil::all();
        $tipoClinetes = TipoCliente::all();
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();

        $pessoaSingular = Pessoa::find($cliente->pessoas_id);
        $pessoaColectiva = Empresa::find($cliente->empresas_id);

        $documentos = Documento::all()->where('clientes_id', $cliente->id);
        $contactos = Contacto::all()->where('clientes_id', $cliente->id);

        $endereco = DB::table('enderecos')
            ->join('municipios', 'enderecos.municipios_id', 'municipios.id')
            ->join('provincias', 'provincias.id', 'municipios.provincias_id')
            ->where('clientes_id', $cliente->id)
            ->get([
                '*', 'enderecos.id as id'
            ])->first();

        $documentosArray = [];
        foreach ($documentos as $doc) {
            $documentosArray[] = [
                'numero' => $doc->numero,
                'emissao' => $doc->emissao,
                'validade' => $doc->validade,
                'tipo_documentos_id' => $doc->tipo_documentos_id,
                'path' => $doc->path,
                'download' => true,
                'download_link' => asset('storage/' . $doc->path),
            ];
        }

        $contactosArray = [];
        foreach ($contactos as $cont) {
            $contactosArray[] = [
                'telefone' => $cont->telefone,
                'email' => $cont->email,
                // Adicione mais campos se necessário
            ];
        }

        $cliente->documentos = $documentosArray;
        $cliente->contactos = $contactosArray;

        $cliente->provincias_id = $endereco->provincias_id;
        $cliente->municipios_id = $endereco->municipios_id;
        $cliente->endereco = $endereco->endereco;
        $cliente->bairro = $endereco->bairro;

        $cliente->nome = $pessoaSingular?->nome;
        $cliente->data_nascimento = $pessoaSingular?->data_nascimento;
        $cliente->generos_id = $pessoaSingular?->generos_id;
        $cliente->estado_civil_id = $pessoaSingular?->estado_civil_id;
        $cliente->nacionalidade = $pessoaSingular?->nacionalidade;

        $cliente->nome_social = $pessoaColectiva?->nome_social;
        $cliente->nome_fantasia = $pessoaColectiva?->nome_fantasia;
        $cliente->tipo_empresa = $pessoaColectiva?->tipo_empresa;
        $cliente->responsavel = $pessoaColectiva?->responsavel;
        $cliente->data_registo = $pessoaColectiva?->data_registo;


        return Inertia::render('Clientes/Edit', [
            'generos' => $generos,
            'estados' => $estados,
            'tipoClientes' => $tipoClinetes,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'tipoDocumentos' => $tipoDocumentos,
            'cliente' => $cliente
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
