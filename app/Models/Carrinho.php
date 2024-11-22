<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;

    public function produto(){
        return $this->hasMany(Produto::class);
    }

    protected $fillable = [
        'id',
        'user_id',
        'produto_id',
        'quantidade'
    ];
}
