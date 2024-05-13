<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable =[
        'descripcion_c',
        

    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

     protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function tag18categoria(){
        return $this->hasMany(Tag18::class, 'id');
        /* un categoria tiene muchas tags */
    }
}
