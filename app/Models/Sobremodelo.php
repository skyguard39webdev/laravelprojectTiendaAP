<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sobremodelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'oculto',
        'destacado',
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class);
    }
}
