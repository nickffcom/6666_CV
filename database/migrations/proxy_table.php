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
        Schema::create('proxy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('name');
            $table->string('type');
            $table->integer('price')->default(10000);
            $table->string('description');
            $table->boolean('change_ip');
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
        Schema::dropIfExists('proxy');
    }
};
