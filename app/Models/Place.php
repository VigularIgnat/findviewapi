<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;
use App\Models\City;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_id',
        'short_info',
        'start_time',
        'close_time',
        'review',
        'photos',
        'city_id',
        'user_id',
        'address',
        'history',
        'price'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
