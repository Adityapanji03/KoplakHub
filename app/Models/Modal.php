<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    use HasFactory;

    protected $table = 'modal';

    protected $fillable = [
        'tanggal',
        'jumlah',
        'periode',
        'keterangan',
        'akun_id'
    ];

    /**
     * Get the user that created the modal entry
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }

    /**
     * Scope a query to only include modal by specific period
     */
    public function scopePeriode($query, $periode)
    {
        return $query->where('periode', $periode);
    }

    /**
     * Scope a query to filter by date range
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }
}
