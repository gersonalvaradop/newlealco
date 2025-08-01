<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDetalle extends Model
{
    use HasFactory;
    protected $table = 'material_detalles';

    protected $fillable = [
        'cantidad',
        'material_id',
        'material_padre',
    ];

    public function padre()
    {
        return $this->hasOne(Material::class, 'id', 'material_padre');
    }
    public function hijo()
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
    
    
}
