<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
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
        if (!$panier || $panier->items->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Votre panier est vide.']);
        }

        $address_id = $request->input('address_id');
        $address = Address::where('id', $address_id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$address) {
            return redirect()->back()->withErrors(['error' => 'Veuillez sélectionner une adresse de livraison valide.']);
        }

        $order = null;

        DB::transaction(function () use ($customer, $panier, &$order, $address) {
            $order = Order::create([
                'customer_id' => $customer->id,
                'address_id' => $address->id,
                'total' => $panier->items->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
                'status' => 'pending',
            ]);

            foreach ($panier->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $panier->items()->delete();
        });

        if ($order) {
            return redirect()->route('orders.show', ['order' => $order->id])->with('message', 'Commande validée avec succès.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de la commande.']);
        }
    }

    public function show(Order $order)
    {
        return inertia('Order', ['order' => $order->load(['items.product', 'address'])]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Utilisateur non authentifié.']);
        }

        $customer = $user->customer;
        if (!$customer) {
            return redirect()->back()->withErrors(['error' => 'Aucun client associé à cet utilisateur.']);
        }

        $orders = Order::where('customer_id', $customer->id)->with('items.product')->get();

        return inertia('OrdersIndex', ['orders' => $orders]);
    }
}