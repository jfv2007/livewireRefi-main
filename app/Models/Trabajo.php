<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    protected $fillable =[
        'id_falla',
        'id_user',
        'id_strabajos',
        'des_trabajo',
        'foto_trabajo',
        'created_at',
        'updated_at',
        'id_tag18',
    ];

    protected $appends = [
        'foto_url',
        'foto1_url'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto_trabajo) {

            /* return Storage::disk('avatars')->url($this->avatar); */
            return  asset('storage/planta/'.$this->foto_trabajo);
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


    public function fallatrabajos(){
        return $this->belongsTo(Falla::class, 'id_falla');
        /*  */
    }

    public function tagstrabajos(){
        return $this->belongsTo(Tag18::class, 'id_tag18s');
        /*  */
    }

    public function trabajosUser(){
        return $this->belongsTo(User::class, 'id_user');
        /*  */
    }

    public function statustraba(){
        return $this->belongsTo(Strabajo::class, 'id_strabajos');
        /* un Tag pertenece a un Status ---especificar el id */
    }

}
