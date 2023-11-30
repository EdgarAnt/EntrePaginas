<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
  // Aquí puedes definir la lógica para determinar si un usuario puede ver todas las categorías
  public function viewAny(User $user)
  {
      // Por ejemplo, todos los usuarios autenticados pueden ver las categorías
      return true;
  }

  // Definir si un usuario puede ver una categoría en específico
  public function view(User $user, Category $category)
  {
      // Un usuario solo puede ver una categoría si es el propietario
      return $user->id === $category->user_id;
  }

  // Definir si un usuario puede crear nuevas categorías
  public function create(User $user)
  {
      // Por ejemplo, todos los usuarios autenticados pueden crear categorías
      return true;
  }

  // Definir si un usuario puede actualizar una categoría
  public function update(User $user, Category $category)
  {
      // Un usuario solo puede actualizar una categoría si es el propietario
      return $user->id === $category->user_id;
  }

  // Definir si un usuario puede eliminar una categoría
  public function delete(User $user, Category $category)
  {
      // Un usuario solo puede eliminar una categoría si es el propietario
      return $user->id === $category->user_id;
  }

  // Definir si un usuario puede restaurar una categoría eliminada
  public function restore(User $user, Category $category)
  {
      // Un usuario solo puede restaurar una categoría si es el propietario
      return $user->id === $category->user_id;
  }

  // Definir si un usuario puede eliminar permanentemente una categoría
  public function forceDelete(User $user, Category $category)
  {
      // Un usuario solo puede eliminar permanentemente una categoría si es el propietario
      return $user->id === $category->user_id;
  }
    /*
    public function manage(User $user, Category $category)
    {
        
        return $user->id === $category->user_id;
        

    }
    */
}
