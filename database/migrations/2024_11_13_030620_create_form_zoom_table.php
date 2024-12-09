<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormZoomTable extends Migration
{
    public function up()
    {
        Schema::create('form_zoom', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('category');
            $table->string('code_office');
            $table->text('description')->nullable(); // Keterangan opsional
            $table->string('proof')->nullable(); // File bukti opsional
            $table->string('unique_code')->unique();
            $table->string('status')->default('Pending'); // Status default
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_zoom');
    }
}


