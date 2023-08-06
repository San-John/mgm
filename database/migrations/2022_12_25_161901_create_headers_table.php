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
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->string('sc_facebook');
            $table->string('sc_linkedin');
            $table->string('sc_instagram');
            $table->string('sc_youtube');
            $table->string('sc_twitter');
            $table->string('sc_whatsapp');
            $table->string('sc_email');
            $table->string('logo_image');
            $table->string('logo_name');
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
        Schema::dropIfExists('headers');
    }
};
