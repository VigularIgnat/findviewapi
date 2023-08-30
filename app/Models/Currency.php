<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
