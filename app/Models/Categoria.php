<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $fillable = ['familia_id','nombre'];

    public function familia(): BelongsTo { return $this->belongsTo(Familia::class); }
    public function productos(): HasMany { return $this->hasMany(Producto::class); }
}
