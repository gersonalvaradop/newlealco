<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptFacturasDETS extends Model
{
    use HasFactory;

    protected $table = 'rpt_facturas_det';

    protected $fillable = [
        "idunico",
        "id",
        "documento",
        "monto",
        "total",
        "linea",
        "sku",
        "descripcion",
        "cantidad",
        "precio",
        "impuesto",
        "estatus",
        "fecha_docum",
        "codigo_barras",
        "material_id",
    ];
}
