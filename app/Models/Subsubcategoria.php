<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsubcategoria extends Model
{
    use HasFactory;

    protected $table = "subsubcategorias";

    protected $fillable = [
        'nombre',
        'subcat_id',
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }
}
