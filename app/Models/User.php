<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Users';          // karena nama tabel kamu `Users`
    protected $primaryKey = 'IdUser';    // primary key di tabel

    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'NoTelepon',
        'Alamat',
        'Kota',
        'Role',
        'IsActive',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    // kalau pakai Laravel default hashing:
    public function setPasswordAttribute($value)
    {
        $this->attributes['Password'] = bcrypt($value);
    }
}
