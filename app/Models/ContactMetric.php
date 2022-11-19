<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id', 'metric_id', 'value', 'number',
    ];

    public function contact() {
        return $this->belongsTo(Contact::class);
    }

    public function metric() {
        return $this->belongsTo(Metric::class);
    }
}
