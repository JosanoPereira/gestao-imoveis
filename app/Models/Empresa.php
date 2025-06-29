<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'empresas';

    protected $fillable = [
        'nome_social',
        'nome_fantasia',
        'tipo_empresa',
        'responsavel',
        'data_registo',
    ];
}
