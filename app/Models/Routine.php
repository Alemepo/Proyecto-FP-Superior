<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'exercises',
        'is_default',
        'gender',
    ];

    protected $casts = [
        'exercises' => 'array', 
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('is_deleted');
    }
}