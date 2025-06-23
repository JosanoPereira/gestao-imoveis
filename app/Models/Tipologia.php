<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipologia extends Model
{
    use SoftDeletes;

    protected $table = 'tipologias';

    protected $fillable = [
        'tipo',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

}
