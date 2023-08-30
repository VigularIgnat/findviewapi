<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\City;
use App\Models\Currency;
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'currency_id',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'type_id');
    }

    public function profile()
    {
        return $this->hasOne(Currency::class);
    }
}
