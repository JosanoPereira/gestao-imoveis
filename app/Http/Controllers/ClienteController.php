<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Documento;
use App\Models\Empresa;
use App\Models\EstadoCivil;
use App\Models\Genero;
use App\Models\Municipio;
use App\Models\Pessoa;
use App\Models\Provincia;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use App\Services\ClienteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ClienteController extends Controller
{
    private array $dados;
    private ClienteService $clienteService;

    public function __construct()
    {
        $generos = Genero::all();
        $estados = EstadoCivil::all();
        $tipoClinetes = TipoCliente::all();
        $provincias = Provincia::all();
        $municipios = Municipio::all();
        $tipoDocumentos = TipoDocumento::all();

        $this->dados = [
            'generos' => $generos,
            'estados' => $estados,
            'tipoClientes' => $tipoClinetes,
            'municipios' => $municipios,
            'provincias' => $provincias,
            'tipoDocumentos' => $tipoDocumentos
        ];

        $this->clienteService = new ClienteService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Clientes/Index', ['clientes' => $this->clienteService->getClientes()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clientes/Create', $this->dados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClienteRequest $request)
    {
        try {
            $this->clienteService->createCliente($request->validated());

            Log::info('Cliente gravado com sucesso');
            return redirect()->route('clientes.index')->with('sucesso', 'Cliente gravado com sucesso');

        } catch (\Exception $exception) {
            Log::error('Erro ao gravar cliente: ' . $exception->getMessage());
            return redirect()->back()->with('erro', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $this->extracted($cliente);

        return Inertia::render('Clientes/Show', $this->dados);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $this->extracted($cliente);
        return Inertia::render('Clientes/Edit', $this->dados);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        try {
            $this->clienteService->updateCliente($request->validated(), $cliente);

            Log::info("Cliente atualizado com sucesso");
            return redirect()->route('clientes.index')->with('sucesso', 'Cliente atualizado com sucesso');

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
            return redirect()->back()->with('erro', 'Erro ao atualizar o cliente');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $this->clienteService->deleteCliente($cliente);
            Log::info("Cliente removido com sucesso: ID {$cliente->id}");
            return redirect()->route('clientes.index')->with('sucesso', 'Cliente removido com sucesso');
        } catch (\Exception $e) {
            Log::error("Erro ao remover cliente: " . $e->getMessage());
            return redirect()->back()->with('erro', 'Erro ao remover o cliente');
        }
    }

    /**
     * @param Cliente $cliente
     * @return void
     */
    private function extracted(Cliente $cliente): void
    {
        $pessoaSingular = Pessoa::find($cliente->pessoas_id);
        $pessoaColectiva = Empresa::find($cliente->empresas_id);

        $documentos = Documento::all()->where('clientes_id', $cliente->id);
        $contactos = Contacto::all()->where('clientes_id', $cliente->id);

        $endereco = DB::table('enderecos')
            ->join('municipios', 'enderecos.municipios_id', 'municipios.id')
            ->join('provincias', 'provincias.id', 'municipios.provincias_id')
            ->where('clientes_id', $cliente->id)
            ->get([
                '*',
                'enderecos.id as id',
                'municipios.id as idMuni',
            ])->first();

        $documentosArray = [];
        foreach ($documentos as $doc) {
            $documentosArray[] = [
                'id' => $doc->id,
                'numero' => $doc->numero,
                'emissao' => $doc->emissao,
                'validade' => $doc->validade,
                'tipo_documentos_id' => $doc->tipo_documentos_id,
                'path' => $doc->path,
                'download' => true,
//                'download_link' => asset('storage/' . $doc->path),
                'download_link' => getFileLink($doc->path),
            ];
        }

        $contactosArray = [];
        foreach ($contactos as $cont) {
            $contactosArray[] = [
                'id' => $cont->id,
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


        $this->dados = [
            ...$this->dados,
            'cliente' => $cliente
        ];
    }
}
