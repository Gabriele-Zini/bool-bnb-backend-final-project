<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentSponsorship extends Model
{
    use HasFactory;

    protected $table = 'apartment_sponsorship';
    //relations with Sponsorship
    public function sponsorship()
    {
        return $this->belongsTo(Sponsorship::class);
    }

    //relations with Apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
