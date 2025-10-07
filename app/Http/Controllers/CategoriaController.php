<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use App\Models\Categoria;
use App\Models\Familia;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $familia_id = $request->get('familia_id');

        $categorias = Categoria::with('familia')
            ->when($q, fn($w) => $w->where('nombre', 'like', "%$q%"))
            ->when($familia_id, fn($w) => $w->where('familia_id', $familia_id))
            ->orderBy('id', 'desc')->paginate(10)->withQueryString();

        $familias = Familia::orderBy('nombre')->get();
        return view('categorias.index', compact('categorias', 'q', 'familias', 'familia_id'));
    }

    public function store(CategoriaStoreRequest $request)
    {
        Categoria::create($request->validated());
        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(CategoriaUpdateRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->exists()) {
            return back()->with('danger', 'No se puede eliminar: tiene productos asociados.');
        }
        $categoria->delete();
        return back()->with('success', 'Categoría eliminada.');
    }
}
