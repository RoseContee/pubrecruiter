<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'owner_type',
        'type', 'name', 'email',
        'website', 'domain',
        'logo', 'network_id', 'network', 'network_link', 'tags',
        'commission', 'commission_type', 'commission_unit', 'exclusive_deal', 'code',
        'offers', 'posts',
        'featured', 'active',
    ];

    public function scopeOwner($query, $user_id) {
        if ($user_id) {
            $query->where('owner_id', $user_id)
                ->where('owner_type', User::class);
        }
    }

    public function scopeNotOwner($query, $user_id) {
        if ($user_id) {
            $query->where(function ($query) use ($user_id) {
                $query->where('owner_id', '<>', $user_id)
                    ->orWhere('owner_type', '<>', User::class);
            });
        }
    }

    public function scopeUserType($query, $user_type) {
        $query->where('type', $user_type == 'Creator' ? 'Brand' : 'Creator');
    }

    public function scopeBrand($query) {
        $query->where('type', 'Brand');
    }

    public function scopeCreator($query) {
        $query->where('type', 'Creator');
    }

    public function scopeDomain($query, $domain) {
        $query->where('domain', $domain);
    }

    public function scopeFeatured($query) {
        $query->where('featured', 1);
    }

    public function scopeNotFeatured($query) {
        $query->where('featured', 0);
    }

    public function scopeActive($query) {
        $query->where('active', 1);
    }

    public function user() {
        return $this->morphTo(__FUNCTION__, 'owner_type', 'owner_id');
    }

    public function metrics() {
        return $this->hasMany(ContactMetric::class);
    }

    public function metric() {
        return $this->hasOne(ContactMetric::class)->ofMany('number', 'max');
    }

    public function network() {
        return $this->belongsTo(Network::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function outreaches() {
        return $this->hasMany(Outreach::class);
    }

    public function feedbacks() {
        return $this->hasMany(Feedback::class, 'domain', 'domain');
    }

    public function subrecords() {
        return $this->hasMany(SubRecord::class);
    }

    public function contact_name() {
        if ($this->owner_type == User::class) return $this->user->name;
        return $this->name;
    }

    public function contact_email() {
        if ($this->owner_type == User::class) return $this->user->email;
        return $this->email;
    }
}
