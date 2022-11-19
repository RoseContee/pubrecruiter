<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_info';

    protected $fillable = [
        'user_id', 'media_kit_link', 'media_kit_description', 'referral_code_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function referral() {
        return $this->belongsTo(ReferralCode::class, 'referral_code_id', 'id');
    }
}
