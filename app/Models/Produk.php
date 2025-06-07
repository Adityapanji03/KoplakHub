<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'stok_produk',
        'deskripsi_produk',
        'gambar_produk'
    ];

    /**
     * Get image URL attribute
     *
     * @return string
     */
    public function getGambarUrlAttribute()
    {
        return $this->gambar_produk ? asset('storage/' . $this->gambar_produk) : asset('images/default-product.png');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
