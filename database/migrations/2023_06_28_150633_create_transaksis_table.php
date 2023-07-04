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
            $table->string('invoice', 100);
            $table->unsignedBigInteger('id_jenis_pakaian');
            $table->foreign('id_jenis_pakaian')->references('id')->on('jenis_pakaian');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('berat', 50);
            $table->string('harga', 50);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->tinyInteger('status')->comment('1 = Belum Selesai, 2 = Selesai');
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
