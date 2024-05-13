<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag18 extends Model
{
    use HasFactory;
    /* protected $guarded = ['id']; */
    protected $fillable =[
        'tag',
        'descripcion',
        'operacion',
        'ubicacion',
        'id_cen',
        'id_planta',
        'id_seccion',
        'id_categoria',
        'id_status',
        'foto',
        'tfalla',
        'ttrabajo',
    ];

    public $timestamps = false;

    protected $appends = [
        'foto_url',
        'foto1_url'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {

            /* return Storage::disk('avatars')->url($this->avatar); */
            return  asset('storage/planta/'.$this->foto);
        }

        return asset('noimage.png');
    }

    public function getFoto1UrlAttribute()
    {
        if ($this->foto1) {

            /* return Storage::disk('avatars')->url($this->avatar); */
            return  asset('storage/planta/'.$this->foto1);
        }
        return asset('noimage.png');
    }


    /* para mostrar los tags con sus items */

    public function tag18Centro(){
        return $this->belongsTo(Centro::class, 'id_cen');
        /* un tag pertenece a un CT ---especificar el id */
    }

    public function tag18Plantas(){
        return $this->belongsTo(Planta::class, 'id_planta');
        /* un tag pertenece a un CT ---especificar el id */
    }

    public function tag18seccion(){
        return $this->belongsTo(Seccion::class, 'id_seccion');
        /* un tag  pertenece a un Seccion ---especificar el id */
    }

    public function tag18categoria(){
        return $this->belongsTo(Categoria::class, 'id_categoria');
        /* un tag pertenece a un Categoria ---especificar el id */
    }

    public function tag18stags(){
        return $this->belongsTo(Stag::class, 'id_status');
        /* un Tag pertenece a un Status ---especificar el id */
    }
 /* para mostrar los elementos de la tabla tag18s */



    /* aca empieza para mostrar datos de la falla */

        public function fallatag(){
            return $this->hasMany(Falla::class, 'id');
            /* una tag tiene muchas fallas */
        }

        public function trabajotag(){
            return $this->hasMany(Trabajo::class, 'id');
            /* una tag tiene muchas trabajos */
        }

    public function scopeSearch($query, $term){
        $term="%term%";
        $query->where(function($query) use ($term){
            $query->where('tag', 'like',$term);
        });
    }
}
