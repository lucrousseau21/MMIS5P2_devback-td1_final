<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Product;
use Illuminate\Http\Request;

class AddToPanierController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);


        //TODO - Bien revoir ça
        $cart = request()->user()->customer->panier()->firstOrCreate();
        // sans les parenthèses, on recup juste la donnée et pas la méthode, les mettre si action

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


        // $panier = Panier::updateOrCreate(
        //     [
        //         'customer_id' => $request->user()->customer->id,
        //         'product_id' => $product->id
        //     ],
        //     [
        //         'quantity' => $request->quantity
        //     ]
        // );

        return redirect()->back()->with('message', 'Produit ajouté au panier');
    }
} 