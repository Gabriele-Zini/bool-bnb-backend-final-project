<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'city', 'street_name', 'latitude', 'longitude', 'visibility', 'image_path', 'street_number', 'postal_code', 'country', 'country_code', 'user_id', 'slug'];

    //mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value) . random_int(1, 10000);
    }


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

    //relations with Views
    public function views()
    {
        return $this->hasMany(View::class);
    }

    //relations with images
    public function images()
    {
        return $this->hasMany(Image::class);
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

    //relations with Apartment_Sponsorship
    public function apartment_sponsorships()
    {
        return $this->belongsToMany(ApartmentSponsorship::class);
    }

    //relations with Apartment_info
    public function apartment_info()
    {
        return $this->hasOne(Apartment_info::class);
    }

    //accessor Title
    public function getTitleAttribute($value)
    {
        return ucwords($this->attributes['title']);
    }
}
