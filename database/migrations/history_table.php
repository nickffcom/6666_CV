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
        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action_id')->nullable();
            $table->string('content');
            $table->string('type');
            $table->integer('total_money');
            $table->string('action_content')->nullable();
            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user')
                  ->onUpdate('NO ACTION')
                  ->onDelete("NO ACTION");
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
        Schema::dropIfExists('history');
    }
};
