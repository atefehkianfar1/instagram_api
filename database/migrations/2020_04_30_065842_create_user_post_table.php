<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //which post belongs to which user
        Schema::create('user_post', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
        });
        //users that i follow
        Schema::create('user_follow', function (Blueprint $table) {
            $table->unsignedBigInteger('me_id');
            $table->foreign('me_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->comment('user that i followed');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::create('user_like', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->unsignedBigInteger('user_id')->comment('this user liked this post');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_post');
    }
}
