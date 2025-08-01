<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptFacturasUpdate extends Model
{
    use HasFactory;

    protected $table = 'rpt_facturas';

    protected $fillable = [
        'idunico',
        'id',
        'tipo_doc',
        'tipodoc',
        'documento',
        'numero',
        'nombre',
        'monto',
        'impuestos',
        'percepcion',
        'descuentos',
        'propinas',
        'total',
        'condicion_pago',
        'condicionpago',
        'forma_de_pago',
        'formadepago',
        'estatus',
        'fecha_docum',
        'hora',
        'registrada_sap',
        'vendedor',
        'nombrevendedor',
        'sucursal',
        'caja',
        'dui',
        'nit',
        'nrc',
        'movil',
        'email',
        'actividad_economica',
        'direccion',
        'codigogeneracion',
        'sellorecibido',
        'pedidosap',
        'entregasap',
        'facturasap',
        'documcontable',
        'mensajemh',
        'liquidado',
        'saldo'
    ];

    public function detalle()
    {
        return $this->hasMany(RptFacturasDTE::class, 'documento', 'documento');
    }
}
