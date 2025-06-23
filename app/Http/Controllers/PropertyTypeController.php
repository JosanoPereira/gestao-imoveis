<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyTypeRequest;
use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyTypes = PropertyType::all();
        return Inertia::render('PropertyTypes/Index', [
            'propertyTypes' => $propertyTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('PropertyTypes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $propertyType = PropertyType::create($request->validated());
            DB::commit();
            return redirect()->route('property-types.index')->with('success', 'Property Type created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create Property Type: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyType $propertyType)
    {
        return Inertia::render('PropertyTypes/Show', [
            'propertyType' => $propertyType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyType $propertyType)
    {
        return Inertia::render('PropertyTypes/Edit', [
            'propertyType' => $propertyType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyTypeRequest $request, PropertyType $propertyType)
    {
        try {
            DB::beginTransaction();
            $propertyType->update($request->validated());
            DB::commit();
            return redirect()->route('property-types.index')->with('success', 'Property Type updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update Property Type: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $propertyType)
    {
        try {
            DB::beginTransaction();
            $propertyType->delete();
            DB::commit();
            return redirect()->route('property-types.index')->with('success', 'Property Type deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete Property Type: ' . $e->getMessage()]);
        }
    }
}
