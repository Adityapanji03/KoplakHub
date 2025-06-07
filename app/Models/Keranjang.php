<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'keranjang';
    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
        'harga'
    ];

    /**
     * Get the product that belongs to the cart item.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Calculate the subtotal for this cart item.
     *
     * @return int
     */
    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->harga;
    }
}
