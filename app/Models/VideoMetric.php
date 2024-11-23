<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'tiktok_url',
        'views',
        'like',
        'comment',
        'share',
        'save',
        'status',
    ];
}
