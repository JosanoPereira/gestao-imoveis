<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypologyRequest;
use App\Models\Tipologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TipologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typologies = Tipologia::all();
        return Inertia::render('Tipologias/Index', [
            'typologies' => $typologies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tipologias/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypologyRequest $request)
    {
        try {
            DB::beginTransaction();
            $typology = Tipologia::create($request->validated());
            DB::commit();
            return redirect()->route('tipologias.index')->with('success', 'Tipologia created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create Tipologia: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipologia $tipologia)
    {
        return Inertia::render('Tipologias/Show', [
            'tipologia' => $tipologia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipologia $tipologia)
    {
        return Inertia::render('Tipologias/Edit', [
            'tipologia' => $tipologia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipologia $tipologia)
    {
        try {
            DB::beginTransaction();
            $tipologia->update($request->all());
            DB::commit();
            return redirect()->route('tipologias.index')->with('success', 'Tipologia updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update Tipologia: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipologia $tipologia)
    {
        try {
            DB::beginTransaction();
            $tipologia->delete();
            DB::commit();
            return redirect()->route('tipologias.index')->with('success', 'Tipologia deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete Tipologia: ' . $e->getMessage()]);
        }
    }
}
