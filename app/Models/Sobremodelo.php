<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sobremodelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class);
    }
}
