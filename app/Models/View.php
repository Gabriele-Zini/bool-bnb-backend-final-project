<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = ['user_ip', 'apartment_id'];


    //relations with Apartment
    public function apartment()
    {
        return $this->hasOne(Apartment::class);
    }
}
