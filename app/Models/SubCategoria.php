<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    
    protected $fillable = [
        'name',
        'id_category',
        
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_subcategoria');
    }
}








    
    

