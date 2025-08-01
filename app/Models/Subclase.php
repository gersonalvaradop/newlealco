<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subclase extends Model
{
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}