<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\BookExchange;
use Illuminate\Support\Facades\Storage;


class ExchangeController extends Controller
{
    /*
    public function index()
    {
        $userId = auth()->id();

        // Obtiene las ofertas de intercambio donde el usuario es el solicitante o el dueño del libro
        $exchanges = BookExchange::where('requester_user_id', $userId)
                        ->orWhere('owner_user_id', $userId)
                        ->with('content', 'requester', 'owner') // Asegúrate de cargar las relaciones necesarias
                        ->get();

        // Filtra los contenidos que no pertenecen al usuario para la creación de nuevas ofertas
        $contentsForExchange = Content::whereDoesntHave('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        // Retorna la vista con las ofertas de intercambio y los contenidos disponibles para intercambio
        return view('exchange.index', compact('exchanges', 'contentsForExchange'));
    }*/
        public function index()
    {
        $userId = auth()->id();

        // Obtiene las ofertas de intercambio enviadas por el usuario
        $sentExchanges = BookExchange::where('requester_user_id', $userId)
                        ->with('content', 'owner') // Asegúrate de cargar las relaciones necesarias
                        ->get();

        // Obtiene las ofertas de intercambio recibidas por el usuario
        $receivedExchanges = BookExchange::where('owner_user_id', $userId)
                        ->with('content', 'requester')
                        ->get();

        return view('exchange.index', compact('sentExchanges', 'receivedExchanges'));
    }

    // Mostrar el formulario para crear una nueva oferta
        public function create()
        {
            $userId = auth()->id(); // ID del usuario autenticado
        
            // Obtiene solo los contenidos que no están asociados al usuario autenticado
            $contents = Content::whereNotIn('id', function ($query) use ($userId) {
                $query->select('content_id')->from('content_user')->where('user_id', $userId);
            })->get();
        
            return view('exchange.create', compact('contents'));
        }

    public function store(Request $request)
    {
        // Valida todos los campos requeridos y opcionales
        $validatedData = $request->validate([
            'content_id' => 'required|exists:contents,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'author' => 'nullable|max:255',
            'publisher' => 'nullable|max:255',
            'year' => 'nullable|digits:4',
            'pages' => 'nullable|integer',
            'isbn' => 'nullable|max:13',
            'condition' => 'required|max:255',
            'offer_message' => 'required|string',
            'image_path' => 'required|image|max:2048',
        ]);
        
        // Encuentra el propietario del libro directamente en la tabla pivote
        $contentOwner = DB::table('content_user')->where('content_id', $validatedData['content_id'])->first();
    
        // Si no hay propietario del libro, devuelve un error
        if (!$contentOwner) {
            return back()->withErrors(['content_id' => 'El propietario del libro no se pudo determinar.'])->withInput();
        }
        
        $imagePath = ''; // Inicializa como string vacío en lugar de null
    if ($request->hasFile('image_path')) {
        $image = $request->file('image_path');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $imagePath = 'images/' . $imageName;
    }
        // Crea la nueva oferta de intercambio
        $bookExchange = new BookExchange([
            'content_id' => $validatedData['content_id'],
            'requester_user_id' => auth()->id(), // Usuario que hace la oferta
            'owner_user_id' => $contentOwner->user_id, // Propietario del contenido
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'author' => $validatedData['author'],
            'publisher' => $validatedData['publisher'],
            'year' => $validatedData['year'],
            'pages' => $validatedData['pages'],
            'isbn' => $validatedData['isbn'],
            'condition' => $validatedData['condition'],
            'status' => 'pending', // Estado inicial de la oferta
            'offer_message' => $validatedData['offer_message'],
            'image_path' => $imagePath, // Ruta de la imagen
        ]);
    
        // Guarda la oferta en la base de datos
        $bookExchange->save();
    
        // Redirige al índice con un mensaje de éxito
        return redirect()->route('exchange.index')->with('success', 'La oferta de intercambio ha sido creada con éxito.');
    }
    


    

    // Mostrar una oferta específica
    public function show($id)
    {
        $exchange = BookExchange::findOrFail($id); // Asegúrate de que 'ExchangeOffer' sea el nombre correcto de tu modelo

        return view('exchange.show', compact('exchange')); // 'exchange' es la variable que pasas a la vista
    }


    // Mostrar el formulario para editar una oferta existente
    public function edit($id)
    {
        $offer = ExchangeOffer::findOrFail($id);
        return view('exchange.edit', compact('offer'));
    }

    // Actualizar una oferta en la base de datos
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'author' => 'nullable|max:255',
            'publisher' => 'nullable|max:255',
            'year' => 'nullable|digits:4',
            'pages' => 'nullable|integer',
            'isbn' => 'nullable|max:13',
            'image_path' => 'nullable|image|max:2048',
            'condition' => 'required|max:255',
        ]);

        $offer = ExchangeOffer::findOrFail($id);
        $offer->update($validatedData);
        // Si estás actualizando la imagen, asegúrate de manejar esto aquí

        return redirect()->route('exchange.index')->with('success', 'Oferta de intercambio actualizada.');
    }

    // Eliminar una oferta de la base de datos
    // Método para simular la finalización del intercambio
    public function destroy(BookExchange $exchange)
{
    // Solo permitir al dueño o al solicitante eliminar la oferta
    if (auth()->id() === $exchange->owner_user_id || auth()->id() === $exchange->requester_user_id) {
        if (in_array($exchange->status, ['cancelled', 'rejected'])) {
            $exchange->delete();
            return redirect()->route('exchange.index')->with('message', 'La oferta ha sido eliminada.');
        } else {
            return back()->withErrors(['message' => 'La oferta no puede ser eliminada en su estado actual.']);
        }
    } else {
        return back()->withErrors(['message' => 'No tienes permiso para eliminar esta oferta.']);
    }
}

    


    // Método para aceptar una oferta
    // Método para simular la aceptación de la oferta y la solicitud de datos del domicilio
    public function accept($exchangeId)
    {
        $exchange = BookExchange::findOrFail($exchangeId);
        
        // Simular que la oferta ha sido aceptada
        $exchange->status = 'accepted';
        $exchange->save();

        // Simular la redirección al formulario de datos de domicilio
        return redirect()->route('exchange.show', $exchangeId)->with('success', 'Oferta aceptada. Por favor, ingresa tus datos de envío.');
    }

    // Método para simular que el usuario envía su dirección de domicilio
    public function address(Request $request, $exchangeId)
    {
        // Simular la recepción de los datos del formulario
        // ...

        // Simular la actualización de la oferta como 'in_process'
        $exchange = BookExchange::findOrFail($exchangeId);
        $exchange->status = 'in_process';
        $exchange->save();

        // Simular la redirección a la página de detalles con mensaje de éxito
        return redirect()->route('exchange.show', $exchangeId)->with('message', 'Datos recibidos. El intercambio está en proceso.');
    }
    public function requestExchange($userId)
    {
        // Asegúrate de que solo los libros del usuario específico se muestren
        $user = User::findOrFail($userId);
        $contents = $user->contents; // Suponiendo que tienes una relación 'books' en tu modelo User

        // Pasar los libros a la vista
        return view('exchange.create', compact('contents'));
    }
        public function reject($id)
    {
        $exchange = BookExchange::findOrFail($id);
        $exchange->status = 'rejected'; // Asegúrate de que 'rejected' sea un estado válido en tu sistema
        $exchange->save();

        return redirect()->route('exchange.show', $exchange->id)->with('status', 'Oferta rechazada');
    }
    public function cancel(Request $request, $exchangeId)
    {
        // Obtener el intercambio por ID
        $exchange = BookExchange::findOrFail($exchangeId);

        // Comprobar si el usuario autenticado es el solicitante
        if (auth()->id() === $exchange->requester_user_id && $exchange->status === 'pending') {
            // Cambiar el estado de la oferta a cancelado o algún otro estado adecuado
            $exchange->status = 'cancelled';
            $exchange->save();

            // Redireccionar con un mensaje de éxito
            return redirect()->route('exchange.index')->with('message', 'Solicitud de intercambio cancelada exitosamente.');
        } else {
            // Redireccionar con un mensaje de error si el usuario no tiene permiso para cancelar
            return redirect()->route('exchange.index')->with('error', 'No tienes permiso para cancelar esta solicitud.');
        }
    }

    
    


    

}




