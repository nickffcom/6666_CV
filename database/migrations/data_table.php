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
        Schema::create('data', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('status')->comment('1: còn , 0 là hết')->default(1);
            $table->json('attr')->nullable();
            $table->integer("service_id")->unsigned()->nullable();
            $table->foreign('service_id')
                  ->references('id')
                  ->on('service');
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
        Schema::dropIfExists('data');
    }
};
