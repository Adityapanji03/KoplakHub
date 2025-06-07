<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunTable extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('nomor_hp')->unique();
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->string('provinsi');
            $table->string('kabupaten_kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->text('detail_alamat');
            $table->timestamps();

            // Foreign Key
            $table->foreign('id_role')->references('id')->on('role')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
}
