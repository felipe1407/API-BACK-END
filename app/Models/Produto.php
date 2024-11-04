<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_product',
        'description',
        'price',
        'mark',
        'imagem',
        'id_user',
        'id_category'
    ];
}
