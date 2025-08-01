<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteJornada extends Model
{
    use HasFactory;
    protected $table = 'rpt_venta_jornada';

    public function claseDetalle()
    {
        return $this->hasOne(Clase::class, 'id', 'clase');
    }

    public function subclaseDetalle()
    {
        return $this->hasOne(Subclase::class, 'id', 'subclase');
    }

}
