<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentUser extends Model
{
    protected $table = 'content_user'; // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel

    // Si tu tabla pivote tiene timestamps, descomenta la siguiente línea
    // public $timestamps = true;

    // Si la tabla tiene un primary key autoincrementable, descomenta la siguiente línea
    // protected $primaryKey = 'id';

    protected $fillable = [
        'content_id',
        'user_id',
        'status',
        'request_message',
        // Agrega otros campos si los hay
    ];

    // Define las relaciones aquí si es necesario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
