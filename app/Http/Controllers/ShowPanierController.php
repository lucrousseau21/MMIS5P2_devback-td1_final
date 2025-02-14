<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ShowPanierController extends Controller
{
    public function __invoke(Request $request)
    {

        $customer = $request->user()->customer;
        $panierItems = $customer->panier()->with('product')->get();
        // $adresses = $customer->adresses;
        
        // $panierItems = Panier::with('product')
        //     ->where('user_id', Auth::id())
        //     ->get();

        // $panier = $request->user()->panier()->with('product')->get();
        return Inertia::render('Panier', ['panierItems' => $panierItems]);
    }
} 