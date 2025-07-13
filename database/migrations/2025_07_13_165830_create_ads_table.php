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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('operator', ['mci', 'irancell', 'rightel']);
            $table->decimal('price', 10, 2);
            $table->integer('views')->default(0);
            $table->string('location');
            $table->timestamp('expires_at');
            $table->string('image_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('operator');
            $table->index('location');
            $table->index('is_featured');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
