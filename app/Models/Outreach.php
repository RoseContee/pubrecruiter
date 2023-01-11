<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outreach extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'contact_id', 'owner_id', 'owner_type',
        'opportunities', 'payment_sent', 'io_date', 'notes',
        'name', 'email', 'manual', 'seen',
    ];

    public function scopeWhose($query, $user_id) {
        $query->where('user_id', $user_id);
    }

    public function scopeNotSeen($query) {
        $query->where('seen', 0)
            ->where('manual', 0);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
