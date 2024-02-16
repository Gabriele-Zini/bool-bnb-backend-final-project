<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment_info extends Model
{
    use HasFactory;
    protected $fillable = ['num_rooms', 'num_beds', 'num_bathrooms', 'mt_square', 'apartment_id'];

    public function apartment()
    {
        return $this->hasOne(Apartment::class);
    }
}
