<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formhosting', function (Blueprint $table) {
            $table->string('status')->default('Menunggu'); // Menambahkan kolom status dengan default 'Menunggu'
        });
    
        Schema::table('form_zoom', function (Blueprint $table) {
            $table->string('status')->default('Menunggu'); // Menambahkan kolom status dengan default 'Menunggu'
        });
    
        Schema::table('forms', function (Blueprint $table) {
            $table->string('status')->default('Menunggu'); // Menambahkan kolom status dengan default 'Menunggu'
        });
    }
    
    public function down()
    {
        Schema::table('form_hosting', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    
        Schema::table('form_zoom', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    
        Schema::table('form_troubleshoot', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
