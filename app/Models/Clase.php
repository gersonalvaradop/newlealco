<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Clase extends Model
{
    public function subclases()
    {
        return $this->hasMany(Subclase::class);
    }
}