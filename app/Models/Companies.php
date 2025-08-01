<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $table = 'companies';

    protected $fillable = [
        'nombre',
        'nit',
        'contacto',
        'fecha',
        'token',
        'token_test',
        'fecha_vencimiento',
        'fecha_vencimiento_test',
        'status',
        'respuesta',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
