<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class URLController extends Controller
{
    public function municipios_by_provincias(Request $request): void
    {
        $municipios = DB::table('municipios')
            ->where('provincias_id', $request->provincias_id)->get();
        echo json_encode($municipios);
    }
}
