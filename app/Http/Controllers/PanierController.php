<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\Panier;
use App\Models\Product;
use Inertia\Inertia;

class PanierController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur non authentifié.']);
        }

        $customer = $user->customer;
        if (!$customer) {
            return redirect()->back()->withErrors(['error' => 'Aucun client associé à cet utilisateur.']);
        }

        $cart = $customer->panier()->firstOrCreate([]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('message', 'Produit ajouté au panier');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Utilisateur non authentifié.']);
        }

        $customer = $user->customer;
        if (!$customer) {
            return redirect()->back()->withErrors(['error' => 'Aucun client associé à cet utilisateur.']);
        }

        $panier = $customer->panier()->with('items.product')->first();
        $panierItems = $panier ? $panier->items : collect();

        $addresses = $customer->addresses()->get();

        return Inertia::render('Panier', [
            'panierItems' => $panierItems,
            'addresses' => $addresses,
        ]);
    }

    public function remove(CartItem $cartItem)
    {
        $user = request()->user();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Utilisateur non authentifié.']);
        }

        $customer = $user->customer;
        if (!$customer) {
            return redirect()->back()->withErrors(['error' => 'Aucun client associé à cet utilisateur.']);
        }

        $panier = $customer->panier()->first();
        if (!$panier || $cartItem->panier_id !== $panier->id) {
            return redirect()->back()->withErrors(['error' => 'Cet article ne vous appartient pas.']);
        }

        $cartItem->delete();

        return redirect()->back()->with('message', 'Produit supprimé du panier');
    }

    public function updateQuantity(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $panierItem = cartItem::findOrFail($id);
    $panierItem->quantity = $request->quantity;
    $panierItem->save();

    return redirect()->back();
}
}
