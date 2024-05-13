<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Falla extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_tag18s',
        'id_usuario',
        'id_sfallas',
        'descripcion_falla',
        'turno',
        'foto_falla',
        'created_at',
        'updated_at',

    ];

    protected $appends = [
        'foto_url',
        'foto1_url'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto_falla) {

            /* return Storage::disk('avatars')->url($this->avatar); */
            return  asset('storage/planta/'.$this->foto_falla);
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



    public function tagfallas()
    {
        return $this->belongsTo(Tag18::class, 'id_tag18s');
        /* una falla pertenece a un Tag ---especificar el id */
    }

    public function fallaUser()
    {
        return $this->belongsTo(User::class, 'id_usuario');
        /* una falla pertenece a un usuario ---especificar el id */
    }


    public function fllastatus()
    {
        return $this->belongsTo(Sfalla::class, 'id_sfallas');
        /* una falla pertenece a un status ---especificar el id */
    }
    //////////////

    public function fallatrabajos()
    {
        return $this->hasMany(Trabajo::class, 'id');
        /* un status  tiene muchas tags */
    }
}
