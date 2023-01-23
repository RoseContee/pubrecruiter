<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'contact_id', 'email', 'response_time', 'note', 'seen',
    ];

    public function scopeNotSeen($query) {
        $query->where('seen', 0);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
