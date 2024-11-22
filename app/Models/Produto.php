<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function subCategoria()
    {
        return $this->belongsTo(SubCategoria::class, 'id_subcategoria');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function carrinho(){
        return $this->hasMany(Carrinho::class, 'id_carrinho');
    }

    use HasFactory;

    protected $fillable = [
        'name_product',
        'description',
        'price',
        'mark',
        'imagem',
        'id_user',
        'id_category',
        'id_subCategory'
    ];
}
