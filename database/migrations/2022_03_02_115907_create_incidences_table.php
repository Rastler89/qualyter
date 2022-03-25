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
        Schema::create('incidences', function (Blueprint $table) {
            $table->id();
            $table->string('store',10)->nullable();
            $table->unsignedBigInteger('client');
            $table->unsignedBigInteger('owner');
            $table->unsignedBigInteger('responsable');
            $table->tinyInteger('impact');
            $table->tinyInteger('status');
            $table->json('comments');
            $table->json('order');
            $table->string('token',8);
            $table->timestamp('closed')->nullable();
            $table->timestamps();

            $table->foreign('client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('owner')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('responsable')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidences');
    }
};
