<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    use HasFactory;

    public function plantas(){
        return $this->hasMany(Planta::class, 'id');
        /* un centro tiene muchas plantas */
    }

    public function tag18Centro(){
        return $this->hasMany(Tag18::class, 'id');
        /* un centro tiene muchas tags */
    }
}
