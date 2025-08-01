<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;
    protected $table = 'proveedores';


    protected $fillable = [
        'codigo',
        'nombre',
        'nit',
        'nrc',
        'telefono',
        'dui',        
        'correo',        
        'nombre_contacto',        
        'telefono_contacto',        
    ];
}
