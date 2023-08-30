<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Place;
class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function places()
    {
        return $this->hasMany(Place::class, 'type_id');
    }
}
