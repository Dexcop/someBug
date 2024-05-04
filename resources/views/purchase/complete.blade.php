<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function show()
    {
        $data = Data::all();

        $data = $data->reverse();

        return $data;
    }

    public function edit($id)
    {
        $data = Data::find($id);
        return view('edit', compact('data'));
    }

    public function viewCart($id)
    {
        $data = Data::find($id);
        return view('cart', compact('data'));
    }

    public function buy(Request $request, $id)
    {
        $item = Data::findOrFail($id);
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity
        ]);

        $totalPrice = $item->price * $request->quantity;

        try {
            if ($item->quantity >= $request->quantity) {
                $itemName = $item->name;
                $quantityPurchased = $request->quantity;

                session()->flash('totalPrice', $totalPrice);
                session()->flash('itemName', $itemName);
                session()->flash('quantityPurchased', $quantityPurchased);

                return redirect()->route('purchase.confirmation', ['id' => $item->id]);

            } else {
                return back()->withErrors(['quantity' => 'Not enough stock available'])->withInput();
            }
        } catch (QueryException $exception) {
            return back()->withErrors(['error' => 'An error occurred during the transaction'])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'name' => 'required|unique:data,name',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'required|image'
        ]);

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = $originalName . '_' . $extension;

            $request->file('image')->storeAs('public/images/' . $fileName);

            Data::findOrFail($id)->update([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $fileName
            ]);

            return redirect()->back()->with('success', 'Item updated successfully.');
        } catch (QueryException $exception) {
            // Handle the error accordingly
            if ($exception->getCode() == 2300) {
                return back()->withErrors(['name' => 'The Name has already been taken'])->withInput();
            }
            // Re-throw the exception if it's not a duplicate key issue
            throw $exception;
        }
    }

    public function delete($id)
    {
        Data::destroy($id);
        return redirect('/admin_dashboard')->with('deleted', 'Item successfully deleted');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:data,name|min:5|max:20',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'required|image'
        ]);

        try {
            $extension = $request->file('image')->getClientOriginalExtension();
            $originalName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);

            $fileName = $originalName . '_' . $extension;

            $request->file('image')->storeAs('public/images/' . $fileName);

            Data::create([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $fileName
            ]);

            return redirect()->back()->with('success', 'Item stored successfully.');
        } catch (QueryException $exception) {
            // Handle the error accordingly
            if ($exception->getCode() == 2300) {
                return back()->withErrors(['name' => 'The Name has already been taken'])->withInput();
            }
            // Re-throw the exception if it's not a duplicate key issue
            throw $exception;
        }
    }
}