<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['message_content', 'name', 'lastname', 'email', 'apartment_id',];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
