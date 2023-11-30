<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferedBook extends Model
{
    use HasFactory;

    protected $table = 'offered_books';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'author',
        'publisher',
        'year',
        'pages',
        'isbn',
        'image_path',
        'condition',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function offeredBooks()
    {
        return $this->hasMany(OfferedBook::class);
    }
        public function exchanges()
    {
        return $this->hasMany(BookExchange::class, 'offered_book_id');
    }
        public function exchangeForContent()
    {
        return $this->belongsTo(Content::class, 'exchange_for_content_id');
    }
}
