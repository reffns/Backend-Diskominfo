<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Nama pemohon
            $table->date('date'); // Tanggal permohonan
            $table->string('category'); // Kategori permohonan
            $table->string('codeOffice'); // Kode kantor
            $table->text('description'); // Deskripsi permohonan
            $table->string('unique_code')->unique(); // Kode unik untuk permohonan
            $table->string('status')->default('pending'); // Status permohonan: pending, completed, dll.
            $table->string('proof')->nullable(); // Bukti file, jika ada
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
        Schema::dropIfExists('administrator');
    }
}

