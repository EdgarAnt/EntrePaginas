<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Content;
    use App\Models\Cart;
    use App\Models\CartItem;

    class CartController extends Controller
    {
        public function addToCart(Request $request, $contentId)
{
    $content = Content::findOrFail($contentId);
    $user = auth()->user();

    // Verificar si el usuario autenticado es el creador del libro
    if ($content->users->contains($user->id)) {
        return back()->with('error', 'No puedes añadir tu propio libro al carrito.');
    }

    $cart = Cart::firstOrCreate(['user_id' => $user->id]);
    
    $cartItem = CartItem::where('cart_id', $cart->id)
                        ->where('content_id', $contentId)
                        ->first();

    if ($cartItem) {
        $cartItem->increment('quantity');
    } else {
        $cart->cartItems()->create([
            'content_id' => $contentId,
            'quantity' => 1,
            // Otros campos que necesites
        ]);
    }

    return redirect()->back()->with('success', 'Contenido añadido al carrito.');
}

        public function showCart()
        {
            $user = auth()->user();
            $cart = Cart::with('cartItems.content')->where('user_id', $user->id)->first();
        
            return view('cart.cart', compact('cart'));
        }
        public function updateCart(Request $request, $cartItemId)
        {
            $cartItem = CartItem::findOrFail($cartItemId);
        
            $quantity = $request->validate(['quantity' => 'required|integer|min:1'])['quantity'];
            $cartItem->update(['quantity' => $quantity]);
        
            return redirect()->back()->with('success', 'Carrito actualizado.');
        }
        
        
        public function removeFromCart($contentId)
        {
            $user = auth()->user();
            
            // Encuentra el carrito del usuario actual. Utiliza first() en lugar de firstOrFail() para manejar el caso en el que el carrito no existe.
            $cart = Cart::where('user_id', $user->id)->first();
            
            // Si no hay un carrito, no hay nada que eliminar.
            if (!$cart) {
                return redirect()->back()->with('error', 'No tienes un carrito activo.');
            }
            
            // Busca el ítem del carrito que coincida con el contentId.
            $cartItem = $cart->cartItems()->where('content_id', $contentId)->first();
            
            // Si el ítem del carrito existe, elimínalo.
            if ($cartItem) {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Contenido eliminado del carrito.');
            } else {
                return redirect()->back()->with('error', 'El contenido no se encuentra en el carrito.');
            }
        }
        public function clearCart(Request $request)
        {
            $user = auth()->user();
            $cart = Cart::where('user_id', $user->id)->firstOrFail();
            $cart->cartItems()->delete(); // Esto vaciará el carrito borrando todos los items.
            
            // Verificar si venimos de un "pago"
            if ($request->input('payment_success')) {
                $message = 'Tu pago ha sido realizado exitosamente.';
            } else {
                $message = 'Carrito vaciado.';
            }

            return redirect()->back()->with('success', $message);
        }
        public function checkout()
        {
            return view('cart.checkout');
        }
        public function processPayment(Request $request)
        {
            // Aquí iría la lógica de procesamiento de pago (simulación)

            // Vaciar el carrito después del proceso de pago simulado
            $user = auth()->user();
            $cart = Cart::where('user_id', $user->id)->first();

            if ($cart) {
                $cart->cartItems()->delete();
            }

            // Redireccionar al usuario al carrito con un mensaje de éxito
            return redirect()->route('cart.show')->with('success', 'Tu pago ha sido realizado exitosamente');
        }



        
    }
