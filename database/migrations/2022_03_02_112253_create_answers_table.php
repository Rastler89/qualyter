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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->datetime('expiration');
            $table->tinyInteger('status')->default(0);
            $table->string('store',10)->nullable();
            $table->json('tasks');
            $table->json('answer')->nullable();
            $table->string('token',8)->nullable();
            $table->unsignedBigInteger('client');
            $table->timestamps();

            $table->foreign('client')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
