<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proprietario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'proprietarios';

    protected $fillable = [
        'pessoas_id',
        'nif',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoas_id');
    }
}
