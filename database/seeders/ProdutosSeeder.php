<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produto;
class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produto::create([
        'name_product' => 'Computador' ,
        'description' => 'Eficiente para jogos e para o trabalho',
        'price' => 3000.00 , 
        'mark' => 'Dell' , 
        'imagem' => '' , 
        'id_user' => '2' ,
        'id_category' => '1' ,
        ]);
    }
}
