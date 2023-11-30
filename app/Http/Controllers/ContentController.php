<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Illuminate\Support\Facades\Validate;
use Illuminate\Validation\Rule;
use App\Policies\ContentPolicy;
use App\Policies\RatingPolicy;
use App\Policies\CategoryPolicy;

class ContentController extends Controller
{
    
    
    public function index()
    {
       

        $contents = auth()->user()->contents;
        return view('content.content-index', compact('contents'));
    }

    public function create()
    {
        return view('content.content-form');
    }

    public function store(Request $request)
    {
       
        $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2048',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'year' => 'required|string|size:4',
            'pages' => 'required|integer',
            'isbn' => 'required|string|size:13',
            'image_temp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
           
        ]);
    
        // Procesamiento y almacenamiento de la imagen
        if ($request->hasFile('image_temp')) {
            $imageName = time().'.'.$request->image_temp->extension();  
            $request->image_temp->move(public_path('images'), $imageName);
            $request->merge(['image_path' => 'images/' . $imageName]);
        }
    
        // Inserción en la tabla y obtención de la instancia del modelo creado
        $content = Content::create($request->all());
    
        // Asociar el contenido con el usuario autenticado
        // Asegúrate de que este código se ejecute solo si hay un usuario autenticado
        if (auth()->check()) {
            $content->users()->attach(auth()->id());
        }
    
        return redirect()->route('content.index')->with('message', 'Contenido creado exitosamente');
    }
    

        public function show(Content $content)
    {
        
        // Relación 'categories' en tu modelo Content
        $contentCategories = $content->categories;
        
        // Relación 'users' en tu modelo Content que indica los usuarios que han publicado el contenido
        $users = $content->users;

        // Relación 'ratings' en tu modelo Content para las calificaciones y comentarios
        $ratings = $content->ratings;

        // Calcular la calificación promedio, si no hay calificaciones, se maneja como 'Sin calificaciones'
        $averageRating = $ratings->avg('rating') ?? 'Sin calificaciones';

        // Verificar si el usuario actual ya ha calificado.
        // Asumiendo que tienes una relación 'ratings' que incluye 'user_id'
        $userHasRated = $content->ratings->where('user_id', auth()->id())->count() > 0;
        
        $userCategories = Category::where('user_id', auth()->id())->get();
        $isOwner = $content->user_id == auth()->id();
        
        // Pasar todas las variables necesarias a la vista, incluyendo las calificaciones, la calificación promedio y los ratings (que incluyen comentarios)
        return view('content.content-show', compact('content', 'userCategories', 'contentCategories', 'users', 'ratings', 'averageRating', 'userHasRated', 'isOwner'));
    }

    
    //calificaciones
    public function rate(Request $request, Content $content)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000', // Ajusta el máximo según tus necesidades
        ]);

        $rating = new Rating();
        $rating->user_id = auth()->id();
        $rating->content_id = $content->id;
        $rating->rating = $request->rating;
        $rating->comments = $request->comments;
        $rating->save();

        return redirect()->back()->with('success', 'Calificación y comentario enviados correctamente.');
    }

    public function editRating(Content $content, Rating $rating)
    {
        
        $this->authorize('update', $rating); // Asegúrate de que el usuario actual es el que creó la calificación

        return view('ratings.edit', compact('rating'));
    }
    public function updateRating(Request $request, Content $content, Rating $rating)
    {
        $this->authorize('update', $rating);
        

        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        $rating->update($validatedData);

        return redirect()->route('content.show', $content->id)->with('success', 'Calificación actualizada.');
    }
     public function destroyRating(Content $content, Rating $rating)
    {
        $this->authorize('delete', $rating);

        $rating->delete();

        return redirect()->route('content.show', $content->id)->with('success', 'Comentario eliminado con éxito.');
    }
    // Método para actualizar un comentario en el controlador
    public function updateComment(Request $request, Content $content, Rating $rating)
    {
        $this->authorize('update', $rating);

        $request->validate([
            'comments' => 'required|string|max:1000', // Ajusta según tus necesidades
        ]);

        $rating->comments = $request->comments;
        $rating->save();

        return redirect()->back()->with('success', 'Comentario actualizado correctamente.');
    }
    public function storeComment(Request $request, Content $content)
    {
        $request->validate([
            'comments' => 'required|string|max:1000', // Ajusta la validación según sea necesario
        ]);
    
        // Buscar la calificación existente del usuario
        $rating = Rating::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'content_id' => $content->id,
            ],
            [
                'rating' => $request->rating, // Esto solo se usará si se está creando una nueva calificación
            ]
        );
    
        // Solo actualizar el comentario
        $rating->comments = $request->comments;
        $rating->save();
    
        return back()->with('success', 'Comentario añadido con éxito.');
    }
    

    public function edit(Content $content)
    {
   
        $this->authorize('update', $content);
        
        // Verifica si el usuario actual puede editar este contenido
     

        return view('content.content-form', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
       
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:2048',
        'author' => 'nullable|string|max:255',
        'publisher' => 'nullable|string|max:255',
        'year' => 'required|string|size:4',
        'pages' => 'nullable|integer',
        'isbn' => 'nullable|string|size:13',
        'price' => 'required|numeric|min:0',
        // No es necesario validar la imagen aquí si vas a reemplazarla de todas formas
    ]);

    // Procesamiento y almacenamiento de la imagen si se proporciona una nueva
    if ($request->hasFile('image_temp')) {
        $imageName = time().'.'.$request->image_temp->extension();  
        $request->image_temp->move(public_path('images'), $imageName);
        $validatedData['image_path'] = 'images/' . $imageName;
    }
   
    // Actualizar los datos en la base de datos
    $content->update($validatedData);

    // Ahora actualiza la sesión del carrito si el contenido está en el carrito
    $cart = session()->get('cart', []);
    if (isset($cart[$content->id])) {
        // Aquí puedes añadir cualquier otro campo que necesites actualizar
        $cart[$content->id]['title'] = $validatedData['title'];
        $cart[$content->id]['description'] = $validatedData['description'];
        if (isset($validatedData['image_path'])) {
            $cart[$content->id]['image_path'] = $validatedData['image_path'];
        }
        session()->put('cart', $cart);
    }

    return redirect()->route('content.show', $content)->with('message', 'Contenido actualizado exitosamente');
    }


    
    public function destroy(Content $content)
    {
       

        // Verifica si el usuario actual puede eliminar este contenido
    
        $content->delete();
        return redirect()->route('content.index')->with('message', 'Contenido eliminado exitosamente');
    }
    // En ContentController.php o en el controlador que prefieras
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
    
        // Asegúrate de que el término de búsqueda no esté vacío.
        if(!empty($searchTerm)) {
            $results = Content::query()
                              ->where('title', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('isbn', 'LIKE', "%{$searchTerm}%")
                              ->get();
    
            return view('search.search-results', compact('results'));
        } else {
            // Si el término de búsqueda está vacío, puedes decidir si devolver una vista diferente o redirigir al usuario.
            return redirect()->back()->with('message', 'Por favor ingresa un término de búsqueda.');
        }
    }
    

    
    /**
     * Agrega el género seleccionado al contenido en cuestión 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
  
    // Asociar categoría con el contenido y el usuario autenticado
    public function addCategory(Request $request, Content $content)
    {
        
        $category = Category::findOrFail($request->category_id);
        if($category->user_id != auth()->id()) {
            return back()->with('error', 'No tienes permiso para añadir esta categoría.');
        }
    
        // Añadir la categoría al contenido si no existe
        $content->categories()->syncWithoutDetaching([$category->id]);
        return back()->with('message', 'Categoría agregada');
    }
    
    // Método para eliminar una categoría del contenido
    public function deleteCategory(Request $request, Content $content)
    {
        // Asegurarse de que la categoría pertenezca al usuario autenticado
        $category = Category::findOrFail($request->category_id);
        if($category->user_id != auth()->id()) {
            return back()->with('error', 'No tienes permiso para eliminar esta categoría.');
        }
    
        // Eliminar la categoría del contenido
        $content->categories()->detach($category->id);
        return back()->with('message', 'Categoría eliminada');
       

    }
   
}

?>
