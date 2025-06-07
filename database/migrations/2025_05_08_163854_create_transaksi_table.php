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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->decimal('biaya_pengiriman', 15, 2)->default(0);
            $table->decimal('total_bayar', 15, 2)->default(0);
            $table->string('metode_pembayaran')->nullable();
            $table->string('nomor_resi')->nullable();
            $table->string('status_pembayaran')->default('pending');
            $table->string('status_pengiriman')->default('dikemas');
            $table->text('alamat_pengiriman')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable();

            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
