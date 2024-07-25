<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('usuarios')->insert([
            'usuario'=> 'jakubj@empresa.com',
            'clave'=> '1234',
        ]);

        DB::table('categorias')->insert([
            [
                'nombre'=> 'Comida modificada',
                'descripcion'=> 'Platos e ingredientes',
            ],
            [
                'nombre'=> 'Bebidas sin',
                'descripcion'=> 'Bebidas sin alcohol',
            ],
            [
                'nombre'=> 'Bebidas con',
                'descripcion'=> 'Bebidas con alcohol',
            ]
        ]);

        DB::table('productos')->insert([
            [
                'nombre'=> 'Harina',
                'descripcion'=> '8 paquetes de 1kg de harina cada uno',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Comida modificada')->value('id'),
                'stock'=> random_int(1, 100),
            ],
            [
                'nombre'=> 'Azúcar',
                'descripcion'=> '20 paquetes de 1kg de azucar cada uno',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Comida modificada')->value('id'),
                'stock'=> random_int(1, 100),
            ],
            [
                'nombre'=> 'Agua sin gas',
                'descripcion'=> 'Pack de 6 de agua sin gas de 1.5L',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Bebidas sin')->value('id'),
                'stock'=> random_int(1, 100),
            ],
            [
                'nombre'=> 'Agua con gas',
                'descripcion'=> 'Pack de 6 de agua con gas de 1.5L',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Bebidas sin')->value('id'),
                'stock'=> random_int(1, 100),
            ],
            [
                'nombre'=> 'Cerveza Tropical',
                'descripcion'=> 'Pack de 6 botellines de la cerveza tropical 0,33cl',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Bebidas con')->value('id'),
                'stock'=> random_int(1, 100),
            ],
            [
                'nombre'=> 'Tequila',
                'descripcion'=> 'Botella de tequila 1L',
                'categoria_id'=> DB::table('categorias')->where('nombre', 'Bebidas con')->value('id'),
                'stock'=> random_int(1, 100),
            ]
        ]);

    }
}
