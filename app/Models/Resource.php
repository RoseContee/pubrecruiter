<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'url', 'logo', 'note', 'type',
    ];

    public function scopeBrand($query) {
        $query->where('type', 'Brand');
    }

    public function scopeCreator($query) {
        $query->where('type', 'Creator');
    }

    public function scopeType($query, $type) {
        $query->where('type', $type);
    }
}
