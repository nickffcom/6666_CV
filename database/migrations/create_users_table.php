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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->integer('is_admin')->default(ROLE_MEMBER); // 1 là user thườngs
            $table->integer('role')->unsigned()->default(ROLE_MEMBER);
            $table->integer('money')->default(0); // k có tiền
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('type_social')->nullable();
            $table->string('social_id')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
