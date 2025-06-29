<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Services\ImovelService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImovelController extends Controller
{
    private $imovelServices;

    public function __construct()
    {
        $this->imovelServices = new ImovelService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Imoveis/Index', [
            'imoveis' => $this->imovelServices->getImoveis()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Imoveis/Create', $this->imovelServices->dataService());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Imovel $imovel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imovel $imovel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imovel $imovel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imovel $imovel)
    {
        //
    }
}
