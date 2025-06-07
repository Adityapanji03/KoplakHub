<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Akun extends Authenticatable
{
    use HasFactory;
    protected $table = 'akun';
    protected $fillable = [
        'nama',
        'username',
        'nomor_hp',
        'password',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'detail_alamat',
        'id_role',
    ];

    protected $hidden = [
        'password',
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
