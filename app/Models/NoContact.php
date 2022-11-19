<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoContact extends Model
{
    use HasFactory;

    protected $table = 'nocontacts';

    protected $fillable = [
        'user_id', 'domain',
    ];

    public function scopeWhose($query, $user) {
        $query->where('user_id', $user);
    }

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
