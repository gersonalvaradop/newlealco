<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';
    protected $fillable = [
        'material_id',
        'concepto',
        'cantidad',
        'user_id',
        'tipo_operacion',
        'fecha',
        'costo',
    ];

    public function material()
    {
        return $this->hasOne(Material::class, 'id','material_id');
    }
}
