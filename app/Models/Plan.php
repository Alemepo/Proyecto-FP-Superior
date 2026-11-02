<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    // Un plan puede tener muchos usuarios suscritos
    public function users()
    {
        return $this->hasMany(User::class);
    }
}