<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name'
    ];

    // A status can belong to many incidents
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}