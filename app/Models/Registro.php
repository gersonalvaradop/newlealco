<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    
     protected $table = 'registros';

    protected $fillable = [
        'fecha',
        'cod_gen_dte',
        'nombre',
        'comercial',
        'valor',
        'pdf',        
        'correo_enviado',        
        'json_data',        
        'tipo_dte',        
    ];
}
