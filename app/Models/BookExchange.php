<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'requester_user_id',
        'owner_user_id',
        'title',               // Asegúrate de incluir todos los campos que estás asignando
        'description',
        'author',
        'publisher',
        'year',
        'pages',
        'isbn',
        'condition',
        'image_path',
        'status',
        'offer_message',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}
