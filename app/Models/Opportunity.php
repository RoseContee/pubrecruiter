<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'description', 'cost_type', 'cost',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
