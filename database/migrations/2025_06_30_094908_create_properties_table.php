<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('properties')) {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('city');
            $table->enum('payment_method', ['cash', 'installment'])->default('cash');
            $table->enum('purpose', ['sold', 'rent'])->default('sold');
            $table->enum('status', ['available', 'sold', 'pending','blocked'])->default('available');
            $table->integer('area');
            $table->integer('bedrooms');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
