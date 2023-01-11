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
        Schema::create('typologies', function (Blueprint $table) {
            $table->id();
            $table->string('type','1')->default('i');
            $table->string('name','20');
            $table->timestamps();
        });

        Schema::table('incidences', function(Blueprint $table) {
            $table->unsignedBigInteger('typology')->nullable();

            $table->foreign('typology')->references('id')->on('typologies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('typologies');

        Schema::table('incidences', function(Blueprint $table) {
            $table->dropColumn('typology');
        });
    }
};
