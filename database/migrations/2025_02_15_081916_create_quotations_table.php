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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('requester_name', 100);
            $table->string('project', 100);
            $table->unsignedBigInteger('number')->unique();
            $table->string('payment_type', 100);
            $table->string('currency', 100);
            $table->text('notes')->nullable();
            $table->json('extra_conditions');
            $table->foreignId('company_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
