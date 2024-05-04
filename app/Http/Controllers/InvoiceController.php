<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function confirmation(Request $request, $id)
    {
        // if (!session()->has('total_price')) {
        //     return redirect()->route('dashboard');
        // }
        // $data = Data::findOrFail($id);
        $invoice = Str::uuid()->toString();

        return view('purchase.complete', [
            'invoice' => $invoice,
            'id' => $id,
            'totalPrice' => session('totalPrice'),
            'itemName' => session('itemName'),
            'quantityPurchased' => session('quantityPurchased'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function complete(Request $request)
    {
        $request->validate([
            'totalPrice' => 'required|numeric',
            'itemName' => 'required|string',
            'quantityPurchased' => 'required|integer',
            'address' => 'required|string',
            'postal' => 'required|string',
            'id' => 'required|integer', // Assuming this is the product ID
            'invoice' => 'required|string' // Assuming this is the invoice identifier or some unique value
        ]);

        try {
            $data = Data::findOrFail($request->id);
            $data->decrement('quantity', $request->quantityPurchased);
            
            $data->save();
            Invoice::create([
                'invoiceNo' => $request->invoice,
                'category' => $data->category,
                'name' => $request->itemName,
                'quantity' => $request->quantityPurchased,
                'address' => $request->address,
                'postal' => $request->postal,
                'total' => $request->totalPrice
            ]);

            if($data->quantity == 0) Data::destroy($request->id);

            return redirect()->back()->with('success', 'Item stored successfully.');
        } catch (QueryException $exception) {
            if ($exception->getCode() == 2300) {
                return back()->withErrors(['invoiceNo' => 'The invoice number has already been taken'])->withInput();
            }
            throw $exception;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}