<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenBlacklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* 
        I will leave ID, just to have some pointer if there were manual deleting 
        of records inside blacklist. 
        */
        Schema::create('token_blacklist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jti')->unique();
            $table->string('revocation_reason');
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
        Schema::dropIfExists('token_blacklist');
    }
}
