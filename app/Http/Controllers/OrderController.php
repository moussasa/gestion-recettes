<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class OrderController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'notes' => 'nullable|string'
        ]);

        $cart = Cart::findOrFail($request->cart_id);
        
        if ($cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide');
        }

        $order = Order::create([
            'cart_id' => $cart->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Ici vous pourriez ajouter l'envoi d'un email de confirmation

        return redirect()->route('order.confirmation', $order->id)
                         ->with('success', 'Commande passée avec succès!');
    }

    public function confirmation(Order $order)
    {
        $order->load('items.recipe','cart');
        return view('order.confirmation', compact('order'));
    }
}
