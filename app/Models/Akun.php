<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Akun extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'detail_alamat',
    ];

    protected $hidden = [
        'password',
    ];
}
