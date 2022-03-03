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
        Schema::create('tasks', function (Blueprint $table) {
           $table->string('code',12)->unique();
           $table->text('name');
           $table->timestamp('expiration');
           $table->tinyInteger('status')->default(0);
           $table->string('priority',30);
           $table->string('owner',50);
           $table->string('store',10);
           $table->unsignedBigInteger('assigned')->nullable();
           $table->text('description')->nullable();
           $table->timestamps();

           $table->primary('code');
           $table->foreign('owner')->references('name')->on('agents')->onDelete('cascade');
           $table->foreign('store')->references('code')->on('stores')->onDelete('cascade');
           $table->foreign('assigned')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
