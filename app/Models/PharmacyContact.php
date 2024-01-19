<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyContact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'email' ,
        'phone',
        'school_id',
        'user_id' ,
        'title',
        'notes'
    ];
    
}
