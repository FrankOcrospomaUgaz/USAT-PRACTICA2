<?php


namespace App\Http\Controllers;

use App\Models\Categoria;

class AjaxController extends Controller
{
    public function categoriasByFamilia($familia_id)
    {
        return Categoria::where('familia_id',$familia_id)
            ->orderBy('nombre')
            ->get(['id','nombre']);
    }
}
