<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeOffer extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'author', 'publisher', 'year', 'pages', 'isbn', 'image_path', 'condition'];
    public function isUserInvolved($userId)
    {
        return $this->requester_user_id === $userId || $this->owner_user_id === $userId;
    }
}
