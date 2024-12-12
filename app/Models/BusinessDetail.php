<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'vendor_id');
    }    

    public function rates()
    {
        return $this->hasMany(BusinessRate::class, 'business_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
