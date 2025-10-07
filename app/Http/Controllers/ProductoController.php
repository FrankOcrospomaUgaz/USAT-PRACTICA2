<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoStoreRequest;
use App\Http\Requests\ProductoUpdateRequest;
use App\Models\Producto;
use App\Models\Familia;
use App\Models\Categoria;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function __construct(){ $this->middleware('auth'); }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $familia_id = $request->get('familia_id');
        $categoria_id = $request->get('categoria_id');

        $productos = Producto::with(['familia','categoria'])
            ->when($q, fn($w)=>$w->where('nombre','like',"%$q%"))
            ->when($familia_id, fn($w)=>$w->where('familia_id',$familia_id))
            ->when($categoria_id, fn($w)=>$w->where('categoria_id',$categoria_id))
            ->orderBy('id','desc')->paginate(10)->withQueryString();

        $familias = Familia::orderBy('nombre')->get();
        $categorias = $familia_id
            ? Categoria::where('familia_id',$familia_id)->orderBy('nombre')->get()
            : collect();

        return view('productos.index', compact('productos','q','familias','categorias','familia_id','categoria_id'));
    }

    public function store(ProductoStoreRequest $request)
    {
        $data = $request->validated();

        // Imagen de perfil
        if ($request->hasFile('imagen_perfil')) {
            $data['imagen_perfil'] = $request->file('imagen_perfil')->store('products/profile','public');
        }

        $producto = Producto::create($data);

        // Galería
        if ($request->hasFile('galeria')) {
            foreach ($request->file('galeria') as $img) {
                $path = $img->store('products/gallery','public');
                ProductImage::create(['product_id'=>$producto->id,'path'=>$path]);
            }
        }

        return back()->with('success','Producto creado correctamente.');
    }

    public function update(ProductoUpdateRequest $request, Producto $producto)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen_perfil')) {
            if ($producto->imagen_perfil) Storage::disk('public')->delete($producto->imagen_perfil);
            $data['imagen_perfil'] = $request->file('imagen_perfil')->store('products/profile','public');
        }

        $producto->update($data);

        // Galería adicional (agregar)
        if ($request->hasFile('galeria')) {
            foreach ($request->file('galeria') as $img) {
                $path = $img->store('products/gallery','public');
                ProductImage::create(['product_id'=>$producto->id,'path'=>$path]);
            }
        }

        return back()->with('success','Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // Borrar imágenes
        if ($producto->imagen_perfil) Storage::disk('public')->delete($producto->imagen_perfil);
        foreach ($producto->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }
        $producto->delete();
        return back()->with('success','Producto eliminado.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return back()->with('success','Imagen eliminada.');
    }
}
