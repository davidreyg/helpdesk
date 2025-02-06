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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('names', 200);
            $table->string('paternal_surname', 200);
            $table->string('maternal_surname', 200);
            $table->string('email', 100);
            $table->integer('phone')->unsigned();
            $table->date('birth_date');
            $table->string('document_type', 100);
            $table->integer('document_number')->unsigned();
            $table->string('gender', 100);
            $table->string('address', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
