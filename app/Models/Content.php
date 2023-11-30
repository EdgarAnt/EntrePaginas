<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'author', 
        'publisher', 
        'year', 
        'pages', 
        'isbn', 
        'image_path', 
        'link_path',
        'price',
    ];

    // En tu modelo Content.php
    public function users()
        {
            return $this->belongsToMany(User::class, 'content_user');
        }


        public function categories()
        {
            return $this->belongsToMany(Category::class);
        }
        public function ratings()
        {
            return $this->hasMany(Rating::class);
        }
            public function exchangeRequests()
        {
            return $this->hasMany(ContentUser::class);
        }
        
  
}
