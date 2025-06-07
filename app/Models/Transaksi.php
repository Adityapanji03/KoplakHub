<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'akun_id',
        'total_harga',
        'biaya_pengiriman',
        'total_bayar',
        'metode_pembayaran',
        'nomor_resi',
        'status_pembayaran',
        'status_pengiriman',
        'alamat_pengiriman',
        'snap_token',
        'midtrans_order_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'alamat_pengiriman' => 'array',
        'total_harga' => 'decimal:2',
        'biaya_pengiriman' => 'decimal:2',
        'total_bayar' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }

    /**
     * Get the detail items for the transaction.
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    /**
     * Check if the transaction can be cancelled.
     *
     * @return bool
     */
    public function canBeCancelled()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment confirmation can be uploaded.
     *
     * @return bool
     */
    public function canUploadPayment()
    {
        return $this->status === 'pending' && $this->bukti_pembayaran === null;
    }

    /**
     * Get readable status name
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Pembayaran Diproses',
            'shipped' => 'Pesanan Dikirim',
            'delivered' => 'Pesanan Diterima',
            'completed' => 'Transaksi Selesai',
            'cancelled' => 'Dibatalkan',
            'failed' => 'Gagal'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get status color for UI
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'processing' => 'blue',
            'shipped' => 'indigo',
            'delivered' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            'failed' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }
}
