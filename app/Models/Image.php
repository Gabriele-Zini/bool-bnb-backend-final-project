<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['image_path', 'apartment_id', "cover_image"];
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
