<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{

    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->foreignId('follower_id')->constrained('users');
            $table->foreignId('followed_id')->constrained('users');
            $table->primary(['follower_id', 'followed_id']);
        });
    }


    public function down()
    {
        Schema::dropIfExists('follow');
    }
}
