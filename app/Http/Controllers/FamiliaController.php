<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $familias = Familia::when($q, fn($w)=>$w->where('nombre','like',"%$q%"))
            ->orderBy('nombre')->paginate(10)->withQueryString();
        return view('familias.index', compact('familias','q'));
    }
}

