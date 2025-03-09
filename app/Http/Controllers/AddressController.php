<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $addresses = $customer->addresses;

        return inertia('Addresses', ['addresses' => $addresses]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $user = $request->user();
        $customer = $user->customer;

        if ($request->input('is_default', false)) {
            $customer->addresses()->update(['is_default' => false]);
        }

        $address = new Address($request->all());
        $address->customer_id = $customer->id;
        $address->save();

        return Redirect::route('addresses.index');
    }

    public function setDefault(Request $request, $id)
    {
        $user = $request->user();
        $customer = $user->customer;

        $address = Address::where('id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$address) {
            return Redirect::back()->withErrors(['error' => 'Adresse non trouvée.']);
        }

        $customer->addresses()->update(['is_default' => false]);

        $address->is_default = true;
        $address->save();

        return Redirect::route('addresses.index');
    }
}