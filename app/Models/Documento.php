<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'clientes_id',
        'tipo_documentos_id',
        'path',
        'numero',
        'emissao',
        'validade',
        'vitalicio',
    ];
}
