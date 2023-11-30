<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Todos los usuarios pueden ver cualquier contenido
        return true;
    }

    public function view(User $user, Content $content)
    {
        // Si todos los usuarios pueden ver todo el contenido, simplemente retorna true
        return true;
    }

    public function create(User $user)
    {
        // Todos los usuarios autenticados pueden crear contenido
        return true;
    }

    public function update(User $user, Content $content)
    {
        // Un usuario solo puede actualizar su propio contenido
        return $content->users()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Content $content)
    {
        // Un usuario solo puede eliminar su propio contenido
        return $content->users()->where('user_id', $user->id)->exists();
    }

     

}