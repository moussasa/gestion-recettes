<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
  public function index(Request $request)
    {
        $cart = $this->getCart($request);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        // dd($request);
        $request->validate([
            'addToCartFormRecetteId' => 'required|exists:recipes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $recipe=Recipe::find($request->addToCartFormRecetteId);
        $cart = $this->getCart($request);
        
        $existingItem = $cart->items()->where('recipe_id', $recipe->id)->first();
        
        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'recipe_id' => $recipe->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Recette ajoutée au panier');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item->update(['quantity' => $request->quantity]);
        
        return redirect()->back()->with('success', 'Panier mis à jour');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Recette retirée du panier');
    }

    private function getCart(Request $request)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        } else {
            $sessionId = $request->session()->get('cart_session_id');
            
            if (!$sessionId) {
                $sessionId = Str::random(40);
                $request->session()->put('cart_session_id', $sessionId);
            }
            
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }
        
        return $cart;
    }

     public function checkout(Request $request)
    {
        $cart = $this->getCart($request);
        return view('cart.checkout', compact('cart'));
    }
}
