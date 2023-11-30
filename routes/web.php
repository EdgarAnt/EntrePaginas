<?php


use App\Models\Content;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookExchangeController;
use App\Http\Controllers\ExchangeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Solo los usuarios autenticados pueden acceder a estas rutas
Route::middleware('auth')->group(function () {
    // Rutas de recurso para 'content'
    
    Route::get('/content/main', function () {
        $contents = Content::all();
        $categories = Category::all();
        return view('content.content-main', compact('contents', 'categories'));
    })->name('content-main');
    
    
    Route::resource('content', ContentController::class)->middleware('verified');

    //busqueda 
    Route::get('/search', [ContentController::class, 'search'])->name('search');
    
    //calificaciones
    Route::post('/content/{content}/rate', [ContentController::class, 'rate'])->name('content.rate');
    Route::get('/content/{content}/ratings/{rating}/edit', [ContentController::class, 'editRating'])->name('content.ratings.edit')->middleware('auth');
    Route::put('/content/{content}/ratings/{rating}', [ContentController::class, 'updateRating'])->name('content.ratings.update')->middleware('auth');
    Route::delete('/content/{content}/ratings/{rating}', [ContentController::class, 'destroyRating'])->name('content.ratings.destroy');
    Route::patch('/content/{content}/ratings/{rating}/updateComment', [ContentController::class, 'updateComment'])->name('ratings.updateComment');
    Route::post('/content/{content}/ratings', [ContentController::class, 'storeComment'])->name('ratings.comments.store');

    //intercambio de libros
    // Uso de Route::resource agrupará las operaciones CRUD básicas para book_exchanges
Route::resource('book_exchanges', BookExchangeController::class);

// Esta ruta para mostrar el formulario de creación de un intercambio parece correcta
// Asegúrate de que el parámetro {content} corresponda con el que esperas en el método create del controlador
Route::get('book_exchanges/create/{content}', [BookExchangeController::class, 'create'])
    ->name('book_exchanges.create');

// Ruta para mostrar las solicitudes de intercambio recibidas por el usuario actual
Route::get('book/requests', [BookExchangeController::class, 'requests'])
    ->name('book.requests');

// Rutas adicionales si necesitas funcionalidades específicas no cubiertas por Route::resource
// Por ejemplo, si tienes una vista separada que lista libros específicamente (fuera del índice de intercambios)
// routes/web.php

Route::get('/book/index', [BookExchangeController::class, 'index'])->name('book.book-index');

// web.php o el archivo de rutas correspondiente

Route::get('/book/{id}', [BookExchangeController::class, 'show'])->name('book.show');

// Si tienes operaciones que no se ajustan a la estructura de Route::resource, como una acción personalizada,
// puedes definirlas manualmente
Route::post('book_exchanges/{id}/accept', [BookExchangeController::class, 'accept'])
    ->name('book_exchanges.accept');

Route::post('book_exchanges/{id}/reject', [BookExchangeController::class, 'reject'])
    ->name('book_exchanges.reject');


    //nueva ruta para los libros parte 2
  Route::resource('exchanges', ExchangeController::class);
  Route::get('/exchanges/create/{userId}', [ExchangeController::class, 'create'])->name('exchange.create'); // Route::resource('exchanges', ExchangeController::class);
    //Route::get('/exchange/create', [ExchangeController::class, 'create'])->name('exchange.create');
    Route::get('/exchange/index', [ExchangeController::class, 'index'])->name('exchange.index');
    Route::post('/exchanges/{exchange}/accept', [ExchangeController::class, 'accept'])->name('exchanges.accept');
    Route::post('/exchanges/{exchange}/address', [ExchangeController::class, 'address'])->name('exchanges.address');
    //Route::delete('/exchanges/{exchange}', [ExchangeController::class, 'destroy'])->name('exchanges.destroy');
    Route::get('/exchanges/request/{userId}', [ExchangeController::class, 'requestExchange'])->name('exchanges.request');
    //cancelar solicitud
    Route::post('/exchanges/{exchange}/cancel', [ExchangeController::class, 'cancel'])->name('exchanges.cancel');
   //eliminar
    Route::delete('/exchanges/{exchange}', [ExchangeController::class, 'destroy'])->name('exchanges.destroy');

    Route::get('/exchanges/{id}/show', [ExchangeController::class, 'show'])->name('exchange.show');

// Ruta para rechazar una oferta
Route::delete('/exchanges/{exchange}/reject', [ExchangeController::class, 'reject'])->name('exchanges.reject');

// Ruta para enviar dirección de envío
Route::post('/exchanges/{exchange}/address', [ExchangeController::class, 'address'])->name('exchanges.address');


 

    // Rutas de recurso para 'category'
    Route::resource('category', CategoryController::class);

    // Rutas adicionales que requieren autenticación
    Route::post('content/{content}/add-category', [ContentController::class, 'addCategory'])->name('content.add-category');
    Route::post('/content/{content}/delete-category', [ContentController::class, 'deleteCategory'])->name('content.delete-category');

    // Rutas del carrito de compras
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/add/{contentId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cartItemId}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // Rutas para el proceso de pago
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/complete-purchase', [CartController::class, 'completePurchase'])->name('purchase.complete');
    Route::post('/cart/process-payment', [CartController::class, 'processPayment'])->name('cart.process-payment');
});

// Rutas públicas
Route::get('/', function () {
    $contents = Content::all();
        $categories = Category::all();
        return view('index', compact('contents', 'categories'));
})->name('index');


// Dentro de tu archivo web.php o de rutas

Route::get('/register', function () {
    return view('auth.register');
})->name('register');





Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');








/*
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/content/main', function () {
    $contents = Content::all();
    $categories = Category::all();
    return view('content.content-main', compact('contents', 'categories'));
})->name('content-main');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas de recurso para 'content'
Route::resource('content', ContentController::class)->middleware('verified');

// Rutas de recurso para 'category'
Route::resource('category', CategoryController::class);

Route::post('content/{content}/add-category', [ContentController::class, 'addCategory'])->name('content.add-category');
Route::post('/content/{content}/delete-category', [ContentController::class, 'deleteCategory'])->name('content.delete-category');

// Rutas del carrito de compras
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add/{contentId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{cartItemId}', [CartController::class, 'updateCart'])->name('cart.update'); // Modificada para usar PATCH
Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // Asegúrate de que esté usando cartItemId
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
//pagos del carrito 
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::post('/complete-purchase', [CartController::class, 'completePurchase'])->name('purchase.complete');
Route::post('/cart/process-payment', [CartController::class, 'processPayment'])->name('cart.process-payment');
*/
