<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stag extends Model
{
    use HasFactory;

    public function tag18stags(){
        return $this->hasMany(Tag18::class, 'id');
        /* un status  tiene muchas tags */
    }
}
