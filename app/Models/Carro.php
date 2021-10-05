<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'producto_id',
        'qty',
        
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
    
