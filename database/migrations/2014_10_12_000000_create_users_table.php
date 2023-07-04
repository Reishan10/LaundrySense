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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('no_telepon', 15)->unique();
            $table->text('alamat');
            $table->string('password');
            $table->tinyInteger('level')->default('0')->comment('0 = Admin, 1 = Pelanggan');
            $table->tinyInteger('status')->default('1')->comment('1 = Aktif, 2 = Tidak Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
