<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormhostingTable extends Migration
{
    public function up()
    {
        Schema::create('formhosting', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('category');
            $table->string('code_office');
            $table->text('description')->nullable();
            $table->string('proof')->nullable(); // Untuk menyimpan path file bukti
            $table->string('unique_code')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('formhosting');
    }
}
