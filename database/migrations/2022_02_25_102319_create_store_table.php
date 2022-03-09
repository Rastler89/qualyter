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
        Schema::create('stores', function (Blueprint $table) {

            $table->id();
            $table->string('code',10);
            $table->text('name');
            $table->boolean('status')->default(true);
            $table->text('phonenumber')->nullable();
            $table->text('email');
            $table->string('language',2);
            $table->unsignedBigInteger('client');
            $table->boolean('contact')->default(true);

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
        Schema::dropIfExists('store');
    }
};
