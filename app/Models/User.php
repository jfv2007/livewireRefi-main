<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    const ROLE_ADMIN ='admin';
    const ROLE_USER = 'user';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        /* 'emai|,
        'created_at',
        'updated_at', */
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url',
    ];



    public function setNameAttribute($value)
    {
       $this->attributes['name']= strtoupper($value);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {

              return Storage::disk('avatars')->url($this->avatar);
             /* return  asset('storage/planta/'.$this->foto1); */

             /*  return  asset('storage/avatars/'.$this->avatar); */
             /*  return  asset('/'.$this->avatar); */
            /* return  asset('storage/planta/'.$this->foto_trabajo); */
        }

        return asset('noimage.png');
    }
}
