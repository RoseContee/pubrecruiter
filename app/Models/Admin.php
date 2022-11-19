<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email', 'password',
    ];

    public function contacts() {
        return $this->morphMany(Contact::class, 'owner');
    }

    public function partnerships() {
        return $this->morphMany(Outreach::class, 'owner');
    }

    public function opportunities() {
        return $this->hasMany(Opportunity::class, 'description');
    }

    public function info() {
        return $this->belongsTo(UserInfo::class);
    }
}
