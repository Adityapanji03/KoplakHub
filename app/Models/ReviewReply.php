<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'reply',
        'admin_id',
    ];

    /**
     * Get the review that this reply belongs to
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the admin who created this reply
     */
    public function admin()
    {
        return $this->belongsTo(Akun::class, 'id');
    }
}
