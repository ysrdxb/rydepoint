<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'meta_title', 'meta_description', 'slug', 'content', 'status'];

    protected static function newFactory(): PageFactory
    {
        //return PageFactory::new();
    }
}
