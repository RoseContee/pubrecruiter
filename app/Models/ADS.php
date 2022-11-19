<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ADS extends Model
{
    use HasFactory;

    protected $table = 'ads';

    protected $fillable = [
        'image', 'link', 'active',
    ];

    public function scopeActive($query) {
        $query->where('active', 1);
    }
}
