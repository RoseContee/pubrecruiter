<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'domain', 'response_time', 'comment',
    ];

    public function scopeWhose($query, $user_id) {
        $query->where('user_id', $user_id);
    }

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
