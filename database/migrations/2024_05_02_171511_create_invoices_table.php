<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceNo');
            $table->string('category');
            $table->string('name');
            $table->integer('quantity');
            $table->text('address');
            $table->string('postal');
            $table->decimal('total', 8, 2); // 8 digits in total, 2 digits after the decimal point
            $table->timestamps(); // optional, for created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
