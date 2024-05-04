<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoiceNo',
        'category',
        'name',
        'quantity',
        'address',
        'postal',
        'total'
    ];

    protected static function booted()
    {
        static::created(function ($invoice) {
            $invoice->invoiceNo = 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
            $invoice->save(); // Re-save the model with the invoice number updated
        });
    }
}