<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiktokAccount extends Model
{
    use HasFactory;

    public function videos()
    {
        return $this->hasMany(TiktokAccountVideo::class, 'tiktok_account_id', 'tiktok_account_id');
    }

    public function getTop12PlayCountAverageAttribute()
    {
        $topVideos = $this->videos()
            ->orderBy('create_time', 'desc')
            ->limit(12)
            ->get();

        $totalPlayCount = $topVideos->sum('play_count');
        $averagePlayCount = $topVideos->count() > 0 ? $totalPlayCount / $topVideos->count() : 0;

        return $averagePlayCount;
    }
}
