<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'clientes_id',
        'municipios_id',
        'endereco',
        'bairro',
    ];
}
