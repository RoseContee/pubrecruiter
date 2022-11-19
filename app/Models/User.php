<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'paid_at', 'expires', 'ad_supported', 'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeBrand($query) {
        $query->where('type', 'Brand');
    }

    public function scopeCreator($query) {
        $query->where('type', 'Creator');
    }

    public function scopeAdSupported($query) {
        $query->where('ad_support', 1);
    }

    public function scopeActive($query) {
        $query->where('active', 1);
    }

    public function contact() {
        return $this->morphOne(Contact::class, 'owner');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function opportunities() {
        return $this->hasMany(Opportunity::class);
    }

    public function outreaches() {
        return $this->hasMany(Outreach::class);
    }

    public function partnerships() {
        return $this->morphMany(Outreach::class, 'owner');
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class);
    }

    public function nocontacts() {
        return $this->hasMany(NoContact::class);
    }

    public function subrecords() {
        return $this->hasMany(SubRecord::class);
    }

    public function info() {
        return $this->hasOne(UserInfo::class);
    }

    public function password_reset() {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }
}
