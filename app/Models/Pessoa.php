<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'generos_id',
        'estado_civil_id',
        'nacionalidade',
    ];

    public function proprietario()
    {
        return $this->hasOne(Proprietario::class);
    }

    public function genero()
    {
        return $this->hasOne(Genero::class, 'generos_id');
    }

    public function estado_civil()
    {
        return $this->hasOne(EstadoCivil::class, 'estado_civil_id');
    }
}
