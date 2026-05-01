<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackPelanggan extends Model
{
    protected $table = 'feedback_pelanggan';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}