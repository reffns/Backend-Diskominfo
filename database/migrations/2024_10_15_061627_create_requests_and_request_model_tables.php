<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsAndRequestModelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->string('category');
            $table->string('codeOffice');
            $table->text('description');
            $table->string('unique_code', 10)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('request_model', function (Blueprint $table) {
            $table->id();
            $table->string('other_column'); // Ganti dengan kolom yang sesuai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
        Schema::dropIfExists('request_model');
    }
}
