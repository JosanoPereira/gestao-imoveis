<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imovel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'imoveis';

    protected $fillable = [
        'area_util',
        'numero_compartimentos',
        'estado_conservacao',
        'tipologias_id',
        'property_types_id',
        'proprietarios_id',
    ];
}
