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
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('nif');
            $table->string('contact');
            $table->string('country');
            $table->string('region');
            $table->string('town');
            $table->string('address');
            $table->string('main_phone',15);
            $table->string('admin_phone',15)->nullable();
            $table->string('all_phone',15)->nullable();
            $table->string('main_email',50);
            $table->string('admin_email',50)->nullable();
            $table->string('all_email',50)->nullable();
            $table->json('services');
            $table->string('area');
            $table->integer('workers');
            $table->json('info_workers');
            $table->integer('travel');
            $table->integer('travel_ah');
            $table->integer('hour');
            $table->integer('hour_ah');
            $table->string('type_payment');
            $table->string('iban');
            $table->string('risk')->nullable();
            $table->string('preventive')->nullable();
            $table->string('certificate_pay')->nullable();
            $table->string('rnt')->nullable();
            $table->string('rlc')->nullable();
            $table->string('tax')->nullable();
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
        Schema::dropIfExists('technicians');
    }
};
