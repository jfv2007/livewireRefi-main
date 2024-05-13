<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strabajo extends Model
{
    use HasFactory;
    
    public function statustraba(){
        return $this->hasMany(Trabajo::class, 'id');
        /* un status  tiene muchas trabajos */
    }
}
