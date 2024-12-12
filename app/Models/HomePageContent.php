<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
    use HasFactory;

    protected $table = 'home_page_contents';
    
    protected $guarded = [];

    protected $casts = [
        'steps' => 'array',
    ];
}
