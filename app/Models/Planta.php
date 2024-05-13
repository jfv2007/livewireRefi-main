<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    use HasFactory;

    protected $fillable =[
        'planta_id',
        'nombre_planta',
        'id_centro',

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

    public function centros(){
        return $this->belongsTo(Centro::class, 'id_centro');
        /* una planta pertenece a un CT ---especificar el id */
    }

    public function tag18Plantas(){
        return $this->hasMany(Tag18::class, 'id');
        /* una planta tiene muchas tags */
    }

}
