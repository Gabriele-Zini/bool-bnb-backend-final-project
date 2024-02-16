<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'city', 'street_name', 'latitude', 'longitude', 'visibility', 'image_path', 'street_number', 'postal_code', 'country', 'user_id',];
}
