<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotation_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained();
            $table->integer('quantity')->unsigned();
            $table->string('description', 255);
            $table->string('unit', 100);
            $table->integer('price')->unsigned();
            $table->string('product', 100);
            $table->string('brand', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_item');
    }
};
