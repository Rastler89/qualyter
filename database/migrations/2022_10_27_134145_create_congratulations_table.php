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
        Schema::create('congratulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client');
            $table->unsignedBigInteger('agent');
            $table->timestamps();

            $table->foreign('client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('agent')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('congratulations');
    }
};
