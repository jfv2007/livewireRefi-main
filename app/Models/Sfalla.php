<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sfalla extends Model
{
    use HasFactory;

    public function fallastatus(){
        return $this->hasMany(Falla::class, 'id');
        /* un status tiene muchas fallas */
    }
}
