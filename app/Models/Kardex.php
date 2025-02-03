<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';
    protected $primaryKey = 'id_kar';
    public $incrementing = false; // Indica que no es autoincremental
    protected $keyType = 'string';

    protected $fillable = [
        'id_kar',
        'codigo_pro',
        'stock_kar',
        'minimo_kar',
        'maximo_kar',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_pro', 'codigo_pro');
    }
}

