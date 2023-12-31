<?php

namespace App\Models;
    
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    //relaciones
   // En tu modelo User.php
public function contents()
{
    return $this->belongsToMany(Content::class, 'content_user');
    
}

    public function ratings()
    
    {
        return $this->hasMany(Rating::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function exchangesMade()
    {
        return $this->hasMany(BookExchange::class, 'requester_user_id');
    }

    public function exchangesReceived()
    {
        return $this->hasMany(BookExchange::class, 'requested_user_id');
    }
        public function publishedBooks()
    {
        return $this->belongsToMany(Content::class, 'content_user')
                    ->withPivot('status', 'request_message')
                    // Suponiendo que 'status' en la tabla pivote indica si un libro está publicado
                    ->wherePivot('status', 'published'); 
    }
        
}
