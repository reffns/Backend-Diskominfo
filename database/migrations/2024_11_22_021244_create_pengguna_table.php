<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama Pengguna
            $table->string('email')->unique(); // Email Pengguna
            $table->string('role'); // Peran (Admin, Staff, dll.)
            $table->timestamp('last_active')->nullable(); // Waktu Terakhir Aktif
            $table->boolean('active')->default(true); // Status Aktif
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}

