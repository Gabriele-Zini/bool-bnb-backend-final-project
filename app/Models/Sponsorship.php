<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;
    protected $fillable = ['price', 'duration', 'name'];


    // relation with apartments
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

    //relations with Apartment_Sponsorship
    public function apartment_sponsorships()
    {
        return $this->belongsToMany(ApartmentSponsorship::class);
    }
}
