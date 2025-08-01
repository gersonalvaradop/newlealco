<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [
        'sku',
        'sku_alterno',
        'codigo_barras',
        'descripcion',
        'descripcion_corta',
        'precio_base',
        'peso_bruto',
        'peso_neto',
        'clase',
        'subclase',
        'unidad_med_compra',
        'cant_min',
        'grupo_impuestos',
        'udf1',
        'udf2',
        'udf3',
        'udf4',
        'umedida',
        'umin',
        'lu',
        'ma',
        'mi',
        'ju',
        'vi',
        'sa',
        'do',
        'desayuno',
        'almuerzo',
        'cena',
        'activo',
        'stock',
        'lleva_inventario',
        'costo_prom',
    ];

    public function clases()
    {
        return $this->hasOne(Clase::class, 'id', 'clase');
    }
    public function detalles()
    {
        return $this->hasMany(MaterialDetalle::class, 'material_padre', 'id');
    }
}
