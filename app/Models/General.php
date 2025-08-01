<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    use HasFactory;
    protected $table = 'rpt_general';
    
    public function detalle()
    {
        return $this->hasMany(RptFacturasDETS::class, 'documento', 'documento');
    }
}
