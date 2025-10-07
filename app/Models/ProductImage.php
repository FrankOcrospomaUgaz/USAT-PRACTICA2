<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id','path'];
    public function product(): BelongsTo { return $this->belongsTo(Producto::class,'product_id'); }
    public function getUrlAttribute(): string { return Storage::url($this->path); }
}
