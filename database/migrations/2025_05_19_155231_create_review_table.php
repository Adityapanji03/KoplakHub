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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            // Ensure a user can only review a product once per transaction
            $table->unique(['akun_id', 'produk_id', 'transaksi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
