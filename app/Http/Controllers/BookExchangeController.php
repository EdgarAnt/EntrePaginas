<?php

namespace App\Http\Controllers;
use App\Models\BookExchange;

use App\Models\Content;
use App\Models\OfferedBook;
use Illuminate\Http\Request;
use App\Notifications\BookExchangeRequested;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class BookExchangeController extends Controller
{
   // BookExchangeController.php

   public function index()
{
    $userId = auth()->id();
    // Recuperar los libros que el usuario ha ofrecido para intercambiar.
    $offeredBooks = OfferedBook::with('user')
                    ->where('user_id', $userId)
                    ->get();

    // Recuperar los intercambios donde los libros del usuario han sido solicitados.
    $requestedExchanges = BookExchange::with('requestedContent', 'requesterUser')
                           ->whereHas('requestedContent', function ($query) use ($userId) {
                               $query->where('user_id', $userId);
                           })
                           ->get();

    return view('book.book-index', compact('offeredBooks', 'requestedExchanges'));
}


   

    

    public function create($contentId)
    {
        // Asegúrate de que el Content existe y pertenece al usuario autenticado
        $content = Content::findOrFail($contentId);
        
        return view('book.book-create', compact('content'));
    }
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:1000',
            'author' => 'nullable|max:255',
            'publisher' => 'nullable|max:255',
            'year' => 'nullable|max:4',
            'pages' => 'nullable|integer',
            'isbn' => 'nullable|max:13',
            'condition' => 'required',
            'image' => 'nullable|image|max:2048', // Asegúrate de que el campo se llame 'image' en el formulario
        ]);

        // Manejar la carga de la imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/offered_books_images');
        }

        // Crear el libro ofrecido
        $offeredBook = OfferedBook::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'author' => $validatedData['author'] ?? null,
            'publisher' => $validatedData['publisher'] ?? null,
            'year' => $validatedData['year'] ?? '2000',
            'pages' => $validatedData['pages'] ?? null,
            'isbn' => $validatedData['isbn'] ?? null,
            'condition' => $validatedData['condition'],
            'image_path' => $imagePath, // Almacenar la ruta de la imagen si se subió alguna
        ]);

        return redirect()->route('book.book-index')->with('success', 'Libro ofrecido con éxito.');
    }
    

        // BookController.php

    // En BookExchangeController.php

    public function show($id)
    {
        // Suponiendo que Content es la clase correcta que corresponde a 'Book'
        $content = \App\Models\Content::findOrFail($id); // Asegúrate de tener el namespace correcto

        // Devuelve una vista y pasa el contenido a esta vista
        return view('book.show', compact('content')); // Asegúrate de que la vista 'book.show' esté esperando una variable $content
    }


    public function acceptExchange(Request $request, $exchangeId)
{
    // Inicia la transacción de la base de datos
    DB::beginTransaction();

    try {
        // Encuentra el intercambio y asegúrate de que puede ser aceptado
        $exchange = BookExchange::findOrFail($exchangeId);
        
        // Verifica si el usuario actual es a quien se le hizo la solicitud
        if ($exchange->requested_user_id !== auth()->id()) {
            return back()->withErrors(['not_requested_user' => 'No tienes permiso para aceptar este intercambio.']);
        }

        // Actualiza la propiedad del libro en la tabla content_user
        DB::table('content_user')
            ->where('content_id', $exchange->requested_content_id)
            ->update(['user_id' => $exchange->requester_user_id]);

        // Marcar el intercambio como aceptado
        $exchange->update(['status' => 'accepted']);

        // Confirma las operaciones
        DB::commit();

        return redirect()->route('book_exchanges.index')->with('success', 'Intercambio aceptado con éxito.');
    } catch (\Exception $e) {
        // Algo salió mal, revierte la transacción
        DB::rollback();
        return back()->withErrors(['error' => 'Ocurrió un error al aceptar el intercambio.']);
    }
}

    public function rejectExchange(Request $request, $exchangeId)
{
    // Encuentra el intercambio y asegúrate de que puede ser rechazado
    $exchange = BookExchange::findOrFail($exchangeId);
    
    // Verifica si el usuario actual es a quien se le hizo la solicitud
    if ($exchange->requested_user_id !== auth()->id()) {
        return back()->withErrors(['not_requested_user' => 'No tienes permiso para rechazar este intercambio.']);
    }

    // Marcar el intercambio como rechazado
    $exchange->update(['status' => 'rejected']);

    return redirect()->route('book_exchanges.index')->with('success', 'Intercambio rechazado.');
    }

}
