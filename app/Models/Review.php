<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'akun_id',
        'produk_id',
        'transaksi_id',
        'rating',
        'review',
        'is_published'
    ];

    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function reply()
    {
        return $this->hasOne(ReviewReply::class);
    }
}
