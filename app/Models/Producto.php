<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    protected $fillable = [
        'familia_id','categoria_id','nombre','descripcion','precio','stock','imagen_perfil'
    ];

    public function familia(): BelongsTo { return $this->belongsTo(Familia::class); }
    public function categoria(): BelongsTo { return $this->belongsTo(Categoria::class); }
    public function images(): HasMany { return $this->hasMany(ProductImage::class,'product_id'); }

    public function getImagenPerfilUrlAttribute(): ?string
    {
        return $this->imagen_perfil ? Storage::url($this->imagen_perfil) : null;
    }
}
