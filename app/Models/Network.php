<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'link',
    ];

    public function contacts() {
        return $this->hasMany(Contact::class);
    }

    public function otherContacts() {
        return $this->hasMany(Contact::class, 'network', 'name');
    }
}
