<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca',
        'modelo',
        'titulo',
        'precio',
        'oculto',
        'peso',
        'tramos',
        'tramos_mts',
        'pcs',
        'subcategoria_id',
        'sobremodelo_id',
        'descripcion',
    ];

    public function carro()
    {
        return $this->hasOne(Carro::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function sobremodelo()
    {
        return $this->belongsTo(Sobremodelo::class);
    }
}
