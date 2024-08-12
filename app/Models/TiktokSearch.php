<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiktokSearch extends Model
{
    use HasFactory;
    public function tiktokAccounts()
    {
        return $this->hasMany(TiktokAccount::class, 'tiktok_search_id', 'id');
    }
    
    public function getTiktokAccountCountAttribute()
    {
        return $this->tiktokAccounts()->count();
    }
}
