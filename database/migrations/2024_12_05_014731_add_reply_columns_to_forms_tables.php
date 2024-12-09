<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReplyColumnsToFormsTables extends Migration
{
    public function up()
    {
        // Tabel FormHosting
        Schema::table('formhosting', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->string('reply_file_url')->nullable();
        });

        // Tabel FormZoom
        Schema::table('form_zoom', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->string('reply_file_url')->nullable();
        });

        // Tabel Form (untuk troubleshoot)
        Schema::table('forms', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->string('reply_file_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('formhosting', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'reply_file_url']);
        });

        Schema::table('form_zoom', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'reply_file_url']);
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'reply_file_url']);
        });
    }
}

