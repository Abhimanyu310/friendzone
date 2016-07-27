<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        TODO Add relations and use relations to fetch/associate data n all instead of finding.
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user1');
            $table->integer('user2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('friend_requests');
    }
}
