<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'city', 'street_name', 'latitude', 'longitude', 'visibility', 'image_path', 'street_number', 'postal_code', 'country', 'user_id',];

    //relations with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relations with Message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //relations with Service
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    //relations with Sponsorship
    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }

    //relations with Apartment_info
    public function apartment_info()
    {
        return $this->hasOne(Apartment_info::class);
    }
}
