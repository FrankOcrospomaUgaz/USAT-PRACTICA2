<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Familia;

class FamiliaSeeder extends Seeder
{
    public function run(): void
    {
        $familias = [
            'Electrónica','Alimentos','Hogar','Ropa','Deportes','Papelería'
        ];
        foreach ($familias as $f) {
            Familia::firstOrCreate(['nombre'=>$f]);
        }
    }
}
