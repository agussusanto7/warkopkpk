<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = ['year', 'title', 'description', 'sort_order'];
    protected $casts = ['year' => 'integer', 'sort_order' => 'integer'];
}
