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
        Schema::create('order_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_id')->unsigned()->nullable();
            $table->string('code')->nullable();
            $table->integer('price_buy');
            $table->integer("user_id")->unsigned()->nullable();
            $table->integer("type")->unsigned()->nullable()->default(MAIN_SHOP);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user');
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
        Schema::dropIfExists('order_service');
    }
};
