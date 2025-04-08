<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'zip' => 'required|numeric|digits:6',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'locality' => $request->locality,
            'landmark' => $request->landmark,
            'country' => '',  // Optional
            'isdefault' => $request->isdefault ? true : false,
        ]);

        return redirect()->route('address.index')->with('success', 'Address added successfully!');
    }

    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }
    
        public function update(Request $request, Address $address)
    {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'zip' => 'required|numeric|digits:6',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
        ]);

        // Update the address details
        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'locality' => $request->locality,
            'landmark' => $request->landmark,
            'country' => '',  // Optional, could be left blank if not needed
            'isdefault' => $request->isdefault ? true : false,
        ]);

        return redirect()->route('address.index')->with('success', 'Address updated successfully!');
    }


    public function delete(Address $address)
    {
        $address->delete();
        return redirect()->route('address.index')->with('success', 'Address deleted successfully!');
    }
}
